cd "C:\xampp\mysql\bin"
./mysqldump.exe -hlocalhost -uroot -p counseling>"C:\Counselor_backup_%date:~-4,4%%date:~-10,2%%date:~-7,2%_%time:~0,2%%time:~3,2%%time:~6,2%.sql"

