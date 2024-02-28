/*
SQLyog Ultimate v12.5.1 (64 bit)
MySQL - 10.4.32-MariaDB : Database - excabsensi
*********************************************************************
*/

/*!40101 SET NAMES utf8 */;

/*!40101 SET SQL_MODE=''*/;

/*!40014 SET @OLD_UNIQUE_CHECKS=@@UNIQUE_CHECKS, UNIQUE_CHECKS=0 */;
/*!40014 SET @OLD_FOREIGN_KEY_CHECKS=@@FOREIGN_KEY_CHECKS, FOREIGN_KEY_CHECKS=0 */;
/*!40101 SET @OLD_SQL_MODE=@@SQL_MODE, SQL_MODE='NO_AUTO_VALUE_ON_ZERO' */;
/*!40111 SET @OLD_SQL_NOTES=@@SQL_NOTES, SQL_NOTES=0 */;
CREATE DATABASE /*!32312 IF NOT EXISTS*/`excabsensi` /*!40100 DEFAULT CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci */;

USE `excabsensi`;

/*Table structure for table `absensi` */

DROP TABLE IF EXISTS `absensi`;

CREATE TABLE `absensi` (
  `id_absensi` int(11) NOT NULL AUTO_INCREMENT,
  `id_user` int(11) NOT NULL,
  `tanggal_absen` date NOT NULL,
  `keterangan_izin` varchar(255) NOT NULL,
  `jam_masuk` time NOT NULL,
  `foto_masuk` varchar(255) NOT NULL,
  `lokasi_masuk` varchar(255) NOT NULL,
  `jam_pulang` time NOT NULL,
  `foto_pulang` varchar(255) NOT NULL,
  `lokasi_pulang` varchar(255) NOT NULL,
  `status` varchar(10) NOT NULL,
  `status_absen` varchar(100) NOT NULL,
  `keterangan_terlambat` varchar(255) NOT NULL DEFAULT '-',
  `keterangan_pulang_awal` varchar(255) NOT NULL DEFAULT '-',
  PRIMARY KEY (`id_absensi`),
  KEY `fk_user_id` (`id_user`),
  CONSTRAINT `fk_user_id` FOREIGN KEY (`id_user`) REFERENCES `user` (`id_user`)
) ENGINE=InnoDB AUTO_INCREMENT=7 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

/*Data for the table `absensi` */

/*Table structure for table `admin` */

DROP TABLE IF EXISTS `admin`;

CREATE TABLE `admin` (
  `id_admin` int(11) NOT NULL AUTO_INCREMENT,
  `email` varchar(255) NOT NULL,
  `username` varchar(255) NOT NULL,
  `password` varchar(255) NOT NULL,
  `image` varchar(255) NOT NULL,
  `role` varchar(255) NOT NULL,
  `id_superadmin` int(11) NOT NULL,
  `id_organisasi` int(11) NOT NULL,
  PRIMARY KEY (`id_admin`),
  KEY `fk_superadmin_id` (`id_superadmin`),
  CONSTRAINT `fk_superadmin_id` FOREIGN KEY (`id_superadmin`) REFERENCES `superadmin` (`id_superadmin`)
) ENGINE=InnoDB AUTO_INCREMENT=5 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

/*Data for the table `admin` */

insert  into `admin`(`id_admin`,`email`,`username`,`password`,`image`,`role`,`id_superadmin`,`id_organisasi`) values 
(1,'smkbinusasmg@gmail.com','binus_mangkang','7c04af245d6daa9ea7c36f771e2364c8','1706104171867.jpg','admin',1,0),
(3,'smkbinusamrg@gmail.com','binus_mranggen','25d55ad283aa400af464c76d713c07ad','1706106756513.jpg','admin',1,0);

/*Table structure for table `cuti` */

DROP TABLE IF EXISTS `cuti`;

CREATE TABLE `cuti` (
  `id_cuti` int(11) NOT NULL AUTO_INCREMENT,
  `awal_cuti` date NOT NULL,
  `akhir_cuti` date NOT NULL,
  `masuk_kerja` date NOT NULL,
  `keperluan_cuti` varchar(200) NOT NULL,
  `status` varchar(100) NOT NULL,
  `id_user` int(11) NOT NULL,
  `id_organisasi` int(11) NOT NULL,
  PRIMARY KEY (`id_cuti`),
  KEY `id_user` (`id_user`),
  KEY `id_organisasi` (`id_organisasi`),
  CONSTRAINT `cuti_ibfk_1` FOREIGN KEY (`id_user`) REFERENCES `user` (`id_user`),
  CONSTRAINT `cuti_ibfk_2` FOREIGN KEY (`id_organisasi`) REFERENCES `organisasi` (`id_organisasi`)
) ENGINE=InnoDB AUTO_INCREMENT=6 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

/*Data for the table `cuti` */

insert  into `cuti`(`id_cuti`,`awal_cuti`,`akhir_cuti`,`masuk_kerja`,`keperluan_cuti`,`status`,`id_user`,`id_organisasi`) values 
(3,'2024-01-01','2024-01-31','2024-02-01','coba','Diajukan',3,3),
(4,'2024-01-26','2024-01-28','2024-01-29','tes','Disetujui',4,1);

/*Table structure for table `jabatan` */

DROP TABLE IF EXISTS `jabatan`;

CREATE TABLE `jabatan` (
  `id_jabatan` int(11) NOT NULL AUTO_INCREMENT,
  `nama_jabatan` varchar(100) NOT NULL,
  `id_admin` int(11) NOT NULL,
  PRIMARY KEY (`id_jabatan`),
  KEY `id_admin` (`id_admin`),
  CONSTRAINT `jabatan_ibfk_1` FOREIGN KEY (`id_admin`) REFERENCES `admin` (`id_admin`)
) ENGINE=InnoDB AUTO_INCREMENT=10 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

/*Data for the table `jabatan` */

insert  into `jabatan`(`id_jabatan`,`nama_jabatan`,`id_admin`) values 
(1,'Kepala Sekolah',1),
(2,'Kepala Sekolah',3),
(3,'Guru',1),
(4,'Guru',3),
(6,'Siswa',1),
(7,'Siswa',3),
(8,'Pak Bon',3);

/*Table structure for table `lokasi` */

DROP TABLE IF EXISTS `lokasi`;

CREATE TABLE `lokasi` (
  `id_lokasi` int(11) NOT NULL AUTO_INCREMENT,
  `nama_lokasi` varchar(255) NOT NULL,
  `alamat` varchar(255) NOT NULL,
  `id_organisasi` int(11) NOT NULL,
  `id_admin` int(11) NOT NULL,
  PRIMARY KEY (`id_lokasi`),
  KEY `id_user` (`id_organisasi`),
  KEY `id_admin` (`id_admin`),
  CONSTRAINT `lokasi_ibfk_1` FOREIGN KEY (`id_admin`) REFERENCES `admin` (`id_admin`)
) ENGINE=InnoDB AUTO_INCREMENT=5 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

/*Data for the table `lokasi` */

insert  into `lokasi`(`id_lokasi`,`nama_lokasi`,`alamat`,`id_organisasi`,`id_admin`) values 
(2,'cabang','ambarawa',3,3),
(3,'cabang','kendal',1,1),
(4,'Cabang','Bawen',1,1);

/*Table structure for table `notifications` */

DROP TABLE IF EXISTS `notifications`;

CREATE TABLE `notifications` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `user_id` int(11) DEFAULT NULL,
  `message` text DEFAULT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp(),
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

/*Data for the table `notifications` */

/*Table structure for table `organisasi` */

DROP TABLE IF EXISTS `organisasi`;

CREATE TABLE `organisasi` (
  `id_organisasi` int(11) NOT NULL AUTO_INCREMENT,
  `nama_organisasi` varchar(255) NOT NULL,
  `alamat` varchar(255) NOT NULL,
  `nomor_telepon` varchar(15) NOT NULL,
  `email_organisasi` varchar(255) NOT NULL,
  `kecamatan` varchar(100) NOT NULL,
  `kabupaten` varchar(100) NOT NULL,
  `provinsi` varchar(100) NOT NULL,
  `id_admin` int(11) NOT NULL,
  `status` varchar(255) NOT NULL,
  `image` varchar(255) NOT NULL,
  PRIMARY KEY (`id_organisasi`),
  KEY `fk_admin_id` (`id_admin`),
  CONSTRAINT `fk_admin_id` FOREIGN KEY (`id_admin`) REFERENCES `admin` (`id_admin`)
) ENGINE=InnoDB AUTO_INCREMENT=7 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

/*Data for the table `organisasi` */

insert  into `organisasi`(`id_organisasi`,`nama_organisasi`,`alamat`,`nomor_telepon`,`email_organisasi`,`kecamatan`,`kabupaten`,`provinsi`,`id_admin`,`status`,`image`) values 
(1,'SMK Bina Nusantara Semarang','Jl. Kemantren Raya No.5, RT.02/RW.04, Wonosari, Kec. Ngaliyan, Kota Semarang, Jawa Tengah 50186','(024) 8662971','smkbinusasmg@yahoo.com','Ngaliyan','Kab.Semarang','Jawa Tengah',1,'pusat',''),
(3,'SMK Bina Nusantara Demak','Gg. Mondosari Tim. No.5, Mondosari, Batursari, Kec. Mranggen, Kabupaten Demak, Jawa Tengah 59567','(024) 76728970','smkbinusamrg@yahoo.com','Kec.Mranggen','Kab.Demak','Jawa Tengah',3,'pusat','1706116863122.jpg');

/*Table structure for table `shift` */

DROP TABLE IF EXISTS `shift`;

CREATE TABLE `shift` (
  `id_shift` int(11) NOT NULL AUTO_INCREMENT,
  `nama_shift` varchar(255) NOT NULL,
  `jam_masuk` time NOT NULL,
  `jam_pulang` time NOT NULL,
  `id_admin` int(11) NOT NULL,
  PRIMARY KEY (`id_shift`),
  KEY `id_admin` (`id_admin`),
  CONSTRAINT `shift_ibfk_1` FOREIGN KEY (`id_admin`) REFERENCES `admin` (`id_admin`)
) ENGINE=InnoDB AUTO_INCREMENT=6 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

/*Data for the table `shift` */

insert  into `shift`(`id_shift`,`nama_shift`,`jam_masuk`,`jam_pulang`,`id_admin`) values 
(2,'Normal','00:07:00','00:14:00',1),
(3,'Reguler','00:07:00','00:14:00',3),
(4,'Bootcamp','07:00:00','15:00:00',3),
(5,'Malam','19:00:00','22:00:00',1);

/*Table structure for table `superadmin` */

DROP TABLE IF EXISTS `superadmin`;

CREATE TABLE `superadmin` (
  `id_superadmin` int(11) NOT NULL AUTO_INCREMENT,
  `email` varchar(255) NOT NULL,
  `username` varchar(255) NOT NULL,
  `password` varchar(255) NOT NULL,
  `image` varchar(255) NOT NULL,
  `role` varchar(255) NOT NULL,
  PRIMARY KEY (`id_superadmin`)
) ENGINE=InnoDB AUTO_INCREMENT=2 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

/*Data for the table `superadmin` */

insert  into `superadmin`(`id_superadmin`,`email`,`username`,`password`,`image`,`role`) values 
(1,'sardewi461@gmail.com','dewi','25d55ad283aa400af464c76d713c07ad','1706104963598.jpg','superadmin');

/*Table structure for table `tokens` */

DROP TABLE IF EXISTS `tokens`;

CREATE TABLE `tokens` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `token` varchar(255) NOT NULL,
  `user_id` int(10) NOT NULL,
  `created` date NOT NULL,
  PRIMARY KEY (`id`),
  KEY `user_id` (`user_id`),
  CONSTRAINT `tokens_ibfk_1` FOREIGN KEY (`user_id`) REFERENCES `user` (`id_user`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1 COLLATE=latin1_swedish_ci;

/*Data for the table `tokens` */

/*Table structure for table `user` */

DROP TABLE IF EXISTS `user`;

CREATE TABLE `user` (
  `id_user` int(11) NOT NULL AUTO_INCREMENT,
  `email` varchar(255) NOT NULL,
  `username` varchar(255) NOT NULL,
  `password` varchar(255) NOT NULL,
  `image` varchar(255) NOT NULL,
  `role` varchar(255) NOT NULL,
  `id_admin` int(11) NOT NULL,
  `id_organisasi` int(11) NOT NULL,
  `id_jabatan` int(11) DEFAULT NULL,
  `id_shift` int(11) DEFAULT NULL,
  `reset_token` varchar(100) DEFAULT NULL,
  `token_expiration` datetime DEFAULT NULL,
  PRIMARY KEY (`id_user`),
  KEY `id_admin` (`id_admin`),
  KEY `id_organisasi` (`id_organisasi`),
  KEY `id_jabatan` (`id_jabatan`),
  KEY `id_shift` (`id_shift`),
  CONSTRAINT `user_ibfk_1` FOREIGN KEY (`id_admin`) REFERENCES `admin` (`id_admin`),
  CONSTRAINT `user_ibfk_2` FOREIGN KEY (`id_organisasi`) REFERENCES `organisasi` (`id_organisasi`),
  CONSTRAINT `user_ibfk_3` FOREIGN KEY (`id_jabatan`) REFERENCES `jabatan` (`id_jabatan`),
  CONSTRAINT `user_ibfk_4` FOREIGN KEY (`id_shift`) REFERENCES `shift` (`id_shift`)
) ENGINE=InnoDB AUTO_INCREMENT=31 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

/*Data for the table `user` */

insert  into `user`(`id_user`,`email`,`username`,`password`,`image`,`role`,`id_admin`,`id_organisasi`,`id_jabatan`,`id_shift`,`reset_token`,`token_expiration`) values 
(2,'dewi@gmail.com','Dewi Pulung Sari','25d55ad283aa400af464c76d713c07ad','User.png','user',3,3,7,3,NULL,NULL),
(3,'ave@gmail.com','Aveceena Intifadha Firdaus Ming','25d55ad283aa400af464c76d713c07ad','User.png','user',3,3,7,3,NULL,NULL),
(4,'layla@gmail.com','Layla Rabi\'atus Syarifah','25d55ad283aa400af464c76d713c07ad','1706149667561.jpg','user',1,1,6,2,NULL,NULL),
(5,'satria@gmail.com','Satria Chandra Pamungkas','25d55ad283aa400af464c76d713c07ad','User.png','user',1,1,6,3,NULL,NULL),
(6,'lintang@gmail.com','Lintang Setiawan','25d55ad283aa400af464c76d713c07ad','User.png','user',3,3,7,3,NULL,NULL),
(7,'dani@gmail.com','Dani Affandi Khoir','25d55ad283aa400af464c76d713c07ad','User.png','user',3,3,7,3,NULL,NULL),
(8,'nizar@gmail.com','Nizar Restu Aji','25d55ad283aa400af464c76d713c07ad','User.png','user',1,1,6,2,NULL,NULL),
(9,'irvanda@gmail.com','Irvanda Ibrahim','25d55ad283aa400af464c76d713c07ad','User.png','user',1,1,6,2,NULL,NULL),
(10,'wahyu@gmail.com','Wahyu Yulianto','25d55ad283aa400af464c76d713c07ad','User.png','user',1,1,6,2,NULL,NULL),
(11,'andi@gmail.com','Andi Saputro','25d55ad283aa400af464c76d713c07ad','User.png','user',1,1,6,2,NULL,NULL),
(12,'yunia@gmail.com','Yuniah Rahmah','25d55ad283aa400af464c76d713c07ad','User.png','user',1,1,6,2,NULL,NULL),
(13,'vanino@gmail.com','Vanino Vanino Ersa Faozan Ramadhan','25d55ad283aa400af464c76d713c07ad','User.png','user',1,1,6,2,NULL,NULL),
(14,'nisa@gmail.com','Khoirul Nisa','25d55ad283aa400af464c76d713c07ad','User.png','user',1,1,6,2,NULL,NULL),
(15,'melyana@gmail.com','Melyana Hasya Depratiwi','25d55ad283aa400af464c76d713c07ad','User.png','user',1,1,6,2,NULL,NULL),
(16,'ardi@gmail.com','Muhamad Ardi Setiawan','25d55ad283aa400af464c76d713c07ad','User.png','user',1,1,6,2,NULL,NULL),
(17,'azizi@gmail.com','Azizi Khoiri Ubaidhil Falah','25d55ad283aa400af464c76d713c07ad','User.png','user',1,1,6,2,NULL,NULL),
(18,'secondta@gmail.com','Secondta Ardiansyah Wicaksono','25d55ad283aa400af464c76d713c07ad','User.png','user',1,1,6,2,NULL,NULL),
(19,'fatiya@gmail.com','Fatiya Salsabila','25d55ad283aa400af464c76d713c07ad','User.png','user',1,1,6,2,NULL,NULL),
(20,'dzakiya@gmail.com','Dzakiya Alfyatun Nufus','25d55ad283aa400af464c76d713c07ad','User.png','user',1,1,6,2,NULL,NULL),
(21,'davina@gmail.com','Davina Cahyani Putri  ','25d55ad283aa400af464c76d713c07ad','User.png','user',3,3,7,4,NULL,NULL),
(22,'bintang@gmail.com','Muhammad Alfan Bintang Fanansyah ','25d55ad283aa400af464c76d713c07ad','User.png','user',3,3,7,4,NULL,NULL),
(23,'niscita@gmail.com','Niscita Candrarini ','25d55ad283aa400af464c76d713c07ad','User.png','user',3,3,7,4,NULL,NULL),
(24,'azifa@gmail.com','Dwi Azifatul Jannah','25d55ad283aa400af464c76d713c07ad','User.png','user',3,3,7,4,NULL,NULL),
(25,'rania@gmail.com','Rania shafa putri ','25d55ad283aa400af464c76d713c07ad','User.png','user',3,3,7,4,NULL,NULL),
(26,'zian@gmail.com','Ziyan Haidar Malika','25d55ad283aa400af464c76d713c07ad','User.png','user',3,3,7,4,NULL,NULL),
(27,'mala@gmail.com','Mala Fillatunnida ','25d55ad283aa400af464c76d713c07ad','User.png','user',3,3,7,4,NULL,NULL),
(28,'faza@gmail.com','Faza Tsania Devi','25d55ad283aa400af464c76d713c07ad','User.png','user',3,3,7,4,NULL,NULL),
(29,'farid@gmail.com','Muhamad Farid Lutfi Hakim','25d55ad283aa400af464c76d713c07ad','User.png','user',3,3,7,4,NULL,NULL),
(30,'secondta@gmail.co','Secondta Ardiansyah Wicaksono','25d55ad283aa400af464c76d713c07ad','User.png','user',1,1,6,2,NULL,NULL);

/*!40101 SET SQL_MODE=@OLD_SQL_MODE */;
/*!40014 SET FOREIGN_KEY_CHECKS=@OLD_FOREIGN_KEY_CHECKS */;
/*!40014 SET UNIQUE_CHECKS=@OLD_UNIQUE_CHECKS */;
/*!40111 SET SQL_NOTES=@OLD_SQL_NOTES */;
