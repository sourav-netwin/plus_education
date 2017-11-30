ALTER TABLE `tbl_course_master` ADD `course_front_image` VARCHAR(200) NULL AFTER `course_image`; 

ALTER TABLE `tbl_program_course` ADD `program_course_description` TEXT NULL AFTER `program_course_name`;

ALTER TABLE `tbl_program_course` CHANGE `program_course_status` `program_course_status` TINYINT(1) NOT NULL DEFAULT '1' COMMENT '1:Active & 0:Inactive';