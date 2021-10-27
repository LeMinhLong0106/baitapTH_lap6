
create database qlnv;
use qlnv;

create table loainv (
	maloai varchar(20) not null primary key,
	tentl varchar(50) not null
);

create table phongban(
	maphong varchar(20) NOT NULL primary key,
	tenphong varchar(50) NOT NULL
);

create table nhanvien (
	manv varchar(10) not null primary key,
    honv varchar(50) not null,
	tennv varchar(50) not null,	
	ngaysinh date not null,
    gioitinh tinyint not null,
	diachi varchar(50) not null,
	anh varchar(250) not null,
	maloai varchar(20) not null,
    maphong varchar(20) not null,
	constraint nv_lnv_fk foreign key (maloai) references loainv (maloai),
    constraint nv_mp_fk foreign key (maphong) references phongban (maphong)
	ON UPDATE CASCADE
	ON DELETE CASCADE
);

create table user (
	username varchar(50) not null primary key,
    passwords varchar(50) not null
);


INSERT INTO loainv (maloai, tentl)
VALUES
('LNV01', 'Quản trị hệ thống'),
('LNV02', 'Quản lý'),
('LNV03', 'Nhân viên giao hàng'),
('LNV04', 'Thu ngân');

INSERT INTO phongban (maphong, tenphong)
VALUES
('PB01', 'Phòng ban 1'),
('PB02', 'Phòng ban 2'),
('PB03', 'Phòng ban 3'),
('PB04', 'Phòng ban 4');

INSERT INTO NHANVIEN (manv, honv, tennv, ngaysinh, gioitinh,  diachi, anh, maloai, maphong) VALUES
('NV01', 'Phan', 'Thanh Hà', 1, '2000-03-08', 'Ninh Hòa', 'anhnv1.png', 'LNV01', 'PB01' ),
('NV02', 'Nguyễn', 'Văn Trí', 1, '2000-10-17', 'Cam Ranh', 'anhnv2.png', 'LNV02', 'PB02'),
('NV03', 'Lê', 'Minh Long', 1, '2000-06-01', 'Cam Lâm', 'anhnv3.png', 'LNV03', 'PB03' ),
('NV04', 'Mang', 'Bảo', 1, '2000-01-13', 'Cam Ranh', 'anhnv4.png', 'LNV04', 'PB04');


INSERT INTO user (username, passwords)
VALUES
('thanhha@gmail.com', '123456'),
('vantri@gmail.com', '123456'),
('minhlong@gmail.com', '123456'),
('mangbao@gmail.com', '123456');