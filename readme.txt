config.php - configure database. It connects the .php files to database, which allows the application to authenticate the user.

index.php - This file allows user to login. If the user has not verified their email, this page will not allow the user to login. Moreover, if the user types in the incorrect     email or password, this page will throw an error and not let the user login.

register.php - At first, if user inputs the email which is already registered, it will say that the email is already registered. Next, if the user enters different passwords in password and confirm password fields, it will say that passwords do not match. 

welcome.php - If the user is able to log in, he/she will be redirected to welcome page. This page will display a message that will display automatically display the users name. If user has entered "user345" as username, this page will say Welcome user345. 

logout.php - When the user will click on logout button, the user will be logged out of his/her account

forgot-password.php - When the user clicks on forgot password, he/she will be prompted to enter an email to reset the password. Once they will click on the link, they will be redirected to change-password.php. 

change-password.php - This page will ask user to enter new password. When the user will insert the new password, the password will be updated.

