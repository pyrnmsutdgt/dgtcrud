<h1>วิธีใช้งานโปรเจ็ค</h1>
1.git clone repo
" git clone https://github.com/pyrnmsutdgt/dgtcrud.git "

2.ลง composer ใหม่
composer -install

3.สร้างไฟล์ .env แล้ว คัดลอก ข้อมูลในไฟล์ .env.example มาวางใน .env แล้วแก้ส่วนต่อไปนี้
"
DB_CONNECTION=sqlite
DB_HOST=127.0.0.1
DB_PORT=3306
DB_DATABASE=laravel
DB_USERNAME=root
DB_PASSWORD=
"

ไปเป็น

"
DB_CONNECTION=mysql
DB_HOST=127.0.0.1
DB_PORT=3307
DB_DATABASE=dgtcrud
DB_USERNAME=root
DB_PASSWORD=
"

4. clone database หรือ import database 
export dgtcrud.sql อกมา จาก phpMyAdmin	หรือใช้คำสั่งในแอพ MySQL ตามนี้ 
"mysqldump -u root -p dgtcrud > dgtcrud.sql"

สร้าง database ใหม่บน phpMyAdmin เครื่้องใหม่

แล้ว import database ไปยังเครื่องใหม่ด้วยคำสั่ง

"mysql -u root -p dgtcrud < dgtcrud.sql"
หรือ
import จากไฟล์ที่ติดอยู่ในหน้าแรกของโปรเจ็ค ไฟล์ที่ชื่อว่า
"dgtcrud.sql"

5.Generate APP_KEY ใหม่ ด้วยคำสั่ง

"php artisan key:generate"

6. สั่งทำงาน
php php artisan serve