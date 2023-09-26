from email.mime import application
from email.mime import application
from time import process_time_ns
from warnings import catch_warnings
import pandas as pd
import psycopg2
import numpy 
from psycopg2.extensions import register_adapter, AsIs
def addapt_numpy_float64(numpy_float64):
    return AsIs(numpy_float64)
def addapt_numpy_int64(numpy_int64):
    return AsIs(numpy_int64)
register_adapter(numpy.float64, addapt_numpy_float64)
register_adapter(numpy.int64, addapt_numpy_int64)
import datetime
import sys
import logging


# Read sourcefile
source_file = sys.argv[1]
table_name= sys.argv[2]


table_columns= sys.argv[3].split(',')
exam_code= sys.argv[4]
tier_id= sys.argv[5]
table_value= sys.argv[6].split(',')




alert_status = 10000
record_count = 0
success_records = 0
error_records = 0

#db connection string
connection = psycopg2.connect(user="postgres",password="pg123",host="localhost",port="5432",database="sscsr_audit")
cursor = connection.cursor()

#start time-stamp
start_time = datetime.datetime.now()
start_timestamp = str(start_time.strftime('%d-%m-%Y %H:%M:%S'))

# Load the xlsx file
excel_data_one = pd.read_excel(source_file)
excel_data = excel_data_one.applymap(lambda x: x.strip() if isinstance(x, str) else x)

# Read the values of the file in the dataframe
data = pd.DataFrame(excel_data, columns=table_columns)
data = data.fillna('NA')
NeededDataColumns = data.columns
ExcelFileDataColumns = excel_data.columns

solution  = NeededDataColumns.intersection(NeededDataColumns)
solution2 = NeededDataColumns.difference(ExcelFileDataColumns)
def updateRecordsData( key, value ):
    upsertSql = "INSERT INTO excel_upload_tracker (tracker_name, tracker_value,file_name) VALUES  ('" + key + "', '" + value + "','NA') ON CONFLICT (tracker_name) DO UPDATE SET tracker_value = excluded.tracker_value,  file_name = excluded.file_name;"
    cursor.execute(upsertSql)
    connection.commit()
#creating LOG file
root_logger= logging.getLogger()
root_logger.setLevel(logging.DEBUG) 
handler = logging.FileHandler('C:/xampp/htdocs/sscsr_audit/dataentry/log/sscsr_log.log', 'w', 'utf-8')
handler.setFormatter(logging.Formatter('%(message)s')) # or whatever
root_logger.addHandler(handler)



if solution2.values.size != 0:
    logging.error("Excel file column and table column are not matched")
    logging.error('not match - wrong column name',solution2.values)
    logging.error("Please Check the Excel file Columns...!")
    print("<p style='color:red'>Excel file column and table column are not matched</p> <p style='color:red'>not match - wrong column name {0} </p> <p style='color:red'>Please Check the Excel file Columns...!</p>".format(solution2.values))
    exit()
else:
    logging.info("Excel file column and table column are matched")
updateRecordsData("process-status", "started")
updateRecordsData("processed", "0")
updateRecordsData("success", "0")
updateRecordsData("error", "0")
updateRecordsData('total', str(data.index.stop))
logging.info("Total Records: %s",data.index.stop)
logging.info("--------------------------------Start------------------------------------------------")
now = datetime.datetime.now()
curr_timestamp = str(now.strftime('%d-%m-%Y %H:%M:%S'))
logging.info("Date/Time: %s ", curr_timestamp)
updateRecordsData("process-status", "started")
for i in data.index:
    now = datetime.datetime.now()
    curr_timestamp = str(now.strftime('%d-%m-%Y %H:%M:%S'))

    try:
        #convetr float into int
        reg_no = int(data['reg_no'][i])
        roll_no = int(data['roll_no'][i])
        post_preference = str(data['post_preference'][i])
        #if record_count % 10000 == 0:
            #logging.info("Current Processing Records: %s",str(record_count))
        #check if data[reg_no][i] is null or not if null then then go to the next row of data frame 
        if data['reg_no'][i] == 'NA'  or len(str(reg_no)) != 11:
            continue
        else:
            
            data_primary_key = str(data['exam_code'][i]).lower()+"_"+tier_id+"_"+str(reg_no)+"_"+str(roll_no)+"_"+str(post_preference)

           
            #get total column count
            count = len(table_columns) +1
            query_placeholders = ', '.join(['%s'] * count )
            trimmed_query_placeholders = query_placeholders.replace(' ', '')
            a_list = [data_primary_key]
            j=0
            for j in range(0,count-1):
                    a_list.append(data[table_columns[j]][i])

            #insert query
            sql = "INSERT INTO " + table_name + " VALUES (%s)" % (trimmed_query_placeholders)
           # print(sql)
            cursor.execute(sql, a_list)
            success_records = success_records + 1
            #print("Success records: ", success_records)
    
    except Exception as err:
        error_records = error_records + 1
        err_row = i + 2
        logging.error("--------------------------------ERROR - %s-------------------------------------------", error_records)
        errorcode = str(err.pgcode)
        if errorcode =='23505':
            logging.error("EXCEL ROW NO  : %s", err_row)
            error_des = "Record Already exists!"
            logging.error("error_des: %s", error_des)
        elif errorcode =='08006':
            logging.error("ERROR         : Connection Failure!")
            error_des = "Connection Failure!"
        elif errorcode =='08003':
            logging.error("ERROR         : Connection Does Not Exist!")
            error_des = "Connection Does Not Exist!"
        elif str(err) == 'list index out of range':
            logging.error("EXCEL ROW NO  : %s", err_row)
            error_des = "Please Check the Excel file Column validation not matched with the table columns"
            logging.error("error_des: ", error_des)
        elif str(err) == "invalid literal for int() with base 10: 'NA'":
            logging.error("EXCEL ROW NO  : %s", err_row)
            error_des = "Not a valid Registration Number or a Empty Field"
            logging.error("ERROR         :%s",error_des)
        else:
            logging.error("EXCEL ROW NO  : %s", err_row)
            error_des = "*New "+str(err)
            logging.error("error_des: %s", error_des)

        err_row = "Row No: " + str(err_row)
        cursor.execute("rollback")
        cursor.execute("INSERT INTO tierbasedexam__excelfile_upload_errors VALUES (%s, %s, %s, %s)", (curr_timestamp, err_row, data_primary_key, error_des.replace("\n", "")))
        connection.commit()

    record_count = i + 1
    updateRecordsData('processed',str(record_count))
    updateRecordsData("success", str(success_records ))
    updateRecordsData("error", str(error_records ))
    connection.commit()
    if((i+1) % alert_status == 0):
        now = datetime.datetime.now()
        curr_timestamp = str(now.strftime('%d-%m-%Y %H:%M:%S'))
updateRecordsData("process-status", "done")
updateRecordsData("process_id", '')
cursor.close()
connection.close()
logging.info("--------------------------------------------------------------------------------------")
logging.info("--------------------------------Result------------------------------------------------")
logging.info("No of Records Processed       : %s", record_count)
logging.info("Records imported successfuly  : %s", success_records)
logging.info("Records not-imported (Errors) : %s", error_records)
end_time = datetime.datetime.now()
end_timestamp = str(end_time.strftime('%d-%m-%Y %H:%M:%S'))
logging.info("Start Time                    : %s", start_timestamp)
logging.info("End Time                      : %s", end_timestamp)
time_diff = end_time - start_time
diff_mins = int(time_diff.total_seconds() / 60)
logging.info("Time Taken                    : %s", time_diff)
logging.info("Time Taken in Minutes         : %s mins", diff_mins)
#diff_secs = diff_mins * 60
#logging.info("Time Taken in Seconds         : %s sec", diff_secs)
logging.info("--------------------------------End--------------------------------------------------")
print("<p style='color:blue'>Total number of records readed {0}</p> <p style='color:green'>Total inserted records {1}</p> <p style='color:red'>Total error records {2}</p>".format(record_count, success_records,error_records))
