-------------------------------------RentingSmartConfig Package 1.0.0--------------------------------------------------

=====================================Release Notes=========================================================

1. The package is still underdevelopment.
2. At the moment it only offers Install script functionality and RentingSmart get leatest deals functionality 
3. More features will be added in the new releases.

=====================================User Guide for Install Utility==========================================

Below is the usage guide for the Install script implementation of the RentingSmartConfig Package v.0.0.0

1. Please open the file "renting_smart_dbconfig.class.php" and add the DB settings at lines 10 - 14. Please do not modify any other lines in this file.

2. Please note that you cannot leave any of these fields empty. The script will stop execution in case it finds any of the fields empty. 

3. The dump file should be present in the /packages/RentingSmartConfig/dumps directory. Later releases will have support for path adjustments.

4. Now please open the shell command and point it to the RocketSled main directory (containing index.php)

5. Please type in the following command: php index.php RentingSmartConfig\RentingSmartInstall mysql_root=MYROOTPASS

6. MYROOTPASS is the password for the DB user defined in step 1.

7. This password will also override the password provided in step 1.

8. The script will delete the existing database (name provided in step 1) and will re-install it and will also import all the table structures from the dump file provided in step 1.    

9. If the database already exists then it will confirm from user before actually deleting and re-installing the database as per the details provided in step 1.

=====================================GOOD LUCK !!!===========================================================