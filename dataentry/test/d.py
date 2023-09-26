def updateRecordsData( filename, data ):
  filename = "" + filename
  f = open(filename, "w")
  f.write(data)
  f.close()

updateRecordsData('a.dat', "1000")