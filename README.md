NXshop Backend

=================================================
Description

The backend app is base on AdminLTE template and include RBAC.

main function list

-- RBAC

------ User management

------ Role management

------ Menu control

------ Route control


-- System Setting

------ Language setup

------ User log record

The backend is easy to install, and for new project is easier to extend new modules base on it, it will make you develop a new project faster and faster.


=================================================
Install

The best way to install this backend app is clone the code or download source code into your site, and doing only two steps see below

1) import rbac.sql to your database;

2) insert two lines code before $application->run();

$cookie = Yii::$app->request->cookies;

$application->language = $cookie->has('language') ? $cookie->getValue('language') : 'en';


The code is for backend language, default it is english version. 


=================================================
Visit Backend

visit by http://webroot/backend/web/

username: admin

password: password

