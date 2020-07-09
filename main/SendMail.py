import smtplib,ssl
from email.mime.multipart import MIMEMultipart
from email.mime.base import MIMEBase
from email.mime.text import MIMEText
from email.utils import formatdate
from email import encoders

print("Start sending mail with file")

username = 'serwis@hardwaretech.pl'
password = ''
send_from = 'serwis@hardwaretech.pl'
send_to = 'wojciech.dziwoki@gmail.com'

# Parametry, które są zawarte w mailu
msg = MIMEMultipart()
msg['From'] = send_from
msg['To'] = send_to
msg['Date'] = formatdate(localtime=True)
msg['Subject'] = ' Zdrowy wybór dzienne'
body = 'Dzień dobry,\n\n ' \
       'W załaczniku znajduje się plik csv z danymi dziennymi sieci Zdrowy wybór.\n\n ' \
       'Pozdrawiamy, \n' \
       'Zespół '

# Tworzenie maila
msg.attach(MIMEText(body))

# logowanie do serwera poczty
smtp = smtplib.SMTP('mail.hardwaretech.pl')
smtp.ehlo()
smtp.starttls()
smtp.login(username, password)

# Wysyłka maila
smtp.sendmail(send_from, send_to.split(','), msg.as_string())
smtp.quit()
print("Mail sended successfully")

              


