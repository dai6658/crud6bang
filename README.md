# CRUD6BANG – Hướng dẫn cài đặt và sử dụng

## 1. Yêu cầu hệ thống

* Hệ điều hành: Windows / macOS / Linux
* Phần mềm: **XAMPP** (Apache + MySQL)
* Trình duyệt web: Chrome, Edge, Firefox,…

## 2. Tải và chuẩn bị mã nguồn

1. Download file **`crud6bang-main.zip`** từ GitHub.
2. Giải nén, bạn sẽ được một thư mục tên **`crud6bang-main`**.
3. Đổi tên thư mục thành **`crud6bang`**.
4. Copy (paste) thư mục **`crud6bang`** vào thư mục **`htdocs`** của XAMPP.

   * Ví dụ đường dẫn:
     `C:\xampp\htdocs\crud6bang`

## 3. Khởi động server

1. Mở **XAMPP Control Panel**.
2. Nhấn **Start** cho hai dịch vụ:

   * Apache
   * MySQL

## 4. Cấu hình kết nối cơ sở dữ liệu

Hệ thống sử dụng **MySQL Server** với cấu hình mặc định như sau:

* **Tên cơ sở dữ liệu**: `ktx_management`
* **Server**: `localhost`
* **User**: `root`
* **Password**: *(để trống)*
* **Port**: `3306`

## 5. Tạo cơ sở dữ liệu

1. Mở trình duyệt và truy cập:

   ```
   http://localhost/crud6bang/index.php
   ```
2. Nhấn vào chức năng **chạy file `setup.php`**.
3. Hệ thống sẽ tự động tạo database và các bảng cần thiết.

## 6. Trường hợp MySQL không dùng port 3306

Nếu MySQL của bạn **không chạy trên port 3306**, thực hiện như sau:

1. Mở các file PHP trong project.
2. Tìm các dòng khai báo kết nối có biến **`$con`** hoặc **`$conn`**.
3. Chỉnh lại port cho đúng với port MySQL bạn đang sử dụng.

Ví dụ:

```php
$con = mysqli_connect("localhost", "root", "", "ktx_management", 3307);
```

## 7. Hoàn tất

Sau khi hoàn thành các bước trên, bạn có thể sử dụng đầy đủ các chức năng của hệ thống CRUD6BANG thông qua trình duyệt.

---

**Ghi chú**: Đảm bảo Apache và MySQL luôn ở trạng thái *Running* khi sử dụng hệ thống.
