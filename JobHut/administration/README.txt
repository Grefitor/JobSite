***********************************************************************

JobHut 1.2.1:
-- An open source job board solution
-- This program is free software: you can redistribute it and/or modify
--   it under the terms of the GNU General Public License as published
--   by the Free Software Foundation, either version 3 of the License,
--   or (at your option) any later version.
--   (http://www.gnu.org/licenses/)

***********************************************************************

Created by:
-- Gregory K. Spranger
--   Chadron State College
--   Assistant Professor
--   greg@spranger.us
--   
--
-- Samuel J. Williams
--   Chadron State College
--   Student
--   mr_dicker@bookdicker.com

***********************************************************************

Motivation:
-- Part of the Information Science & Technology Foundation's
-- mission that:
--   "...supports scholarship programs, service learning
--   opportunities (projects, presentations, etc.), and Information
--   Technology (IT) equipment/service purchases for the Mathematical
--   Sciences' Information Science and Technology (IST) program."

-- If you feel this solution is valuable to you/your organization,
-- and would like to help continue such projects,
-- please consider donating to:

The Information Science and Technology Foundation
Chadron State College Foundation
1000 Main Street
Chadron, NE 69337

(308) 432-6361
crasmussen@csc.edu

***********************************************************************

Technologies used:
-- HTML
-- CSS
-- JavaScript
-- PHP
-- MySQL

***********************************************************************

Description:
-- JobHut is a Web-based application built using HTML/CSS/JavaScript/
-- PHP/MySQL/ that enables you to quickly deploy a multi-user/employer
-- job board. It can be used to setup job boards for specific 
-- countries, regions, or niches. Benefits include:
--   Free
--   Easy to implement
--     SQL file creates MySQL DB schema
--     Only one file to configure
--       9 configurations/variables
--   Simple layout with customizable color
--   Built from the ground up over 4 months/320 person-hours
--     It works
--     Well tested
--     Easily customized
--     XHTML 1.0 Transitional compliancy
--   Built-in ad space
--     Make money by posting ads (e.g. Google AdSense, etc.)

***********************************************************************

JobHut features:
-- **SEARCH**
-- Advanced job search capabilities
--   Keyword(s)
--   Job category
--   Job location
-- **JOBSEEKER**
-- Jobseekers apply via form, which includes
--   Name
--   Email
--   Resume
--   Message
--     Application is forwarded/emailed to employer
-- **EMPLOYER**
-- Employer administration includes:
--   Self registration
--   Email validation
--   Self password retrieval
--   Personal login 
-- Employers add and delete jobs
--   Job posting displays number of "views" and "applications"
-- **SYSTEM**
-- Customizable:
--   Job categories (insert, update, delete)
--   Job locations (insert, update, delete)
--   Banner color
-- Basic user administration tasks
--   Activation
--   Deactivation
--   Change password

***********************************************************************

Instructions:
-- Upload all files and folders to your Web server
-- In the "administration" folder:
--   1) Use the SQL in the file "createTables.sql" to create the
--     MySQL DB schema
--   2) Use the file "manageCategory.php" to insert, update, and delete
--     job categories as needed
--   3) Use the file "manageLocation.php" to insert, update, and delete
--     job locations as needed
--   4) Use the file "manageColor.php" to select banner color
--   **NOTE** It is wise to protect the "administration" folder and
--     all files within using the capabilities of .htaccess
--     Below are links to a few tutorials:
--       http://www.freewebmasterhelp.com/tutorials/htaccess/
--       http://www.4webhelp.net/tutorials/misc/htaccess.php
--       http://www.sitedeveloper.ws/tutorials/htaccess.htm
-- In the "library" folder:
--   1) Alter the file's "process.php" configuration variables
--     located at:
--       LINE 9  - FULLY QUALIFIED WEB DOMAIN ADDRESS
--       LINE 10 - ABSOLUTE PATH WHERE UPLOADED RESUMES WILL BE STORED
--       LINE 13 - COMPANY NAME
--       LINE 14 - DEFAULT EMAIL, FROM WHICH ALL EMAIL WILL BE SENT
--       LINE 17 - WEB SERVER ADDRESS
--       LINE 18 - DATABASE USERNAME
--       LINE 19 - DATABASE PASSWORD
--       LINE 20 - DATABASE NAME
--       LINE 23 - CRYPT SALT
--   2) Update the file "logo.gif" with personal/organization logo
--     Be sure to name personal/organization logo "logo.gif"
--     Size: 175px Width X 100px Height
-- Alter the file "index.php" to include personal/organization content
-- Alter the files "browse.php, delete.php, forgot.php, index.php,
--   insert.php, login.php, member.php, register.php, search.php" to
--   include/not include ad space

***********************************************************************
