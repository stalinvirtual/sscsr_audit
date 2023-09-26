# from plyer import notification

# def send_notification(title, message):
#     notification.notify(
#         title=title,
#         message=message,
#     )

# # Example usage
# send_notification("Hello", "This is a notification message.")
# print(title)

# from flask import Flask, request
# from plyer import notification

# app = Flask(__name__)

# @app.route('/trigger_notification', methods=['POST'])
# def trigger_notification():
#     notification_title = "Notification"
#     notification_message = "Notification from Python Script"
#     notification.notify(
#         title=notification_title,
#         message=notification_message,
#         timeout=10  # Notification display time in seconds
#     )
#     return "Notification triggered"

# if __name__ == '__main__':
#     app.run(host='0.0.0.0', port=5000)

import socket
from plyer import notification

def display_notification(message):
    title = "Remote Notification"
    notification.notify(title=title, message=message, timeout=10)

# Set up a server socket
server_ip = '0.0.0.0'
server_port = 12345
server_socket = socket.socket(socket.AF_INET, socket.SOCK_STREAM)
server_socket.setsockopt(socket.SOL_SOCKET, socket.SO_REUSEADDR, 1)

server_socket.bind((server_ip, server_port))
server_socket.listen(1)

print("Server listening on", server_ip, "port", server_port)

while True:
    client_socket, client_addr = server_socket.accept()
    print("Received connection from", client_addr)
    
    message = client_socket.recv(1024).decode()
    print("Received message:", message)
    
    display_notification(message)

    client_socket.close()
