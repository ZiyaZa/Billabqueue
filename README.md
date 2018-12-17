# Billabqueue
## Introduction
This website is created for Computer Lab Lessons at Bilkent University. The purpose is to decrease the grading time for teaching assistants (TAs). It helps TAs to maintain the queue of students who finished their work and wants to be checked by the TA. This web-based software stores its information in txt files which are located in the subfolder with the same name as URL in the /tmp folder, so it is designed for UNIX/Linux-based web-servers. 

## Installation
Just copy all files and folders to your web folder. In Bilkent University, you should put them into “public_html” folder or into its subfolder. Then you can access it by just going to your folder in the browser.

## Documentation for students
In order to stand in the queue,
1. The student should open the website.
2. They will see a page similar to the one in the photo below:
![](/Screenshots/1.png)
3. The student should enter his name and his PC number, which can be found from the image below on the website. Then, click submit.
If that device has been used before, the student\`s pc number can be automatically identified, without the need to type it each time.

## Documentation for TAs
The control panel for this application can be found at “/admin” page. When you access that, you will be required to enter the admin password. The default password is “password” (without quotes). It is strongly recommended to change the password for security purposes.

After logging in, there will be two buttons on the top left corner for resetting everything about the queue and logging out. 
![](/Screenshots/2.png)

In the first field, you can change the password. Currently, it is impossible to retrieve the forgotten password without looking at it in the /tmp folder. To delete the password and make it the default one, you should delete the file from the subfolder of the /tmp folder.
![](/Screenshots/3.png)

The next one is for removing someone from the queue. You can also remove someone from the queue by clicking on it on queue while being logged in as an admin. Please note that removing someone from this page WILL NOT affect the average wait and grade times while clicking on it on the queue page will affect them.  
![](/Screenshots/4.png)

You can also change the queue sorting type. Currently, you may choose to sort from the first person to the last one or vice versa.  
![](/Screenshots/5.png)

The next field is about TAs\` information. You may change their names and enable/disable the statistics. This includes the number of persons graded and the average wait/grade times.  
![](/Screenshots/6.png)

Then, you can see the IP mapping of the devices according to the PC number. Currently, one PC number can have at most one associated IP. Using another device wouldn\`t overwrite the previous one, so you may need to manually fix the wrong IPs. This list is used for skipping the pc number part for students while adding themselves to the queue.
![](/Screenshots/7.png)

The next field is the IP pattern field. Here you may specify the devices you want to be able to add somebody to the queue by their IPs. You can put * in some parts of the IP to allow all numbers in that part. To accept the whole world, you should write "\*.\*.\*.\*" (without quotes). The IPs of all devices in the Bilkent network start with 139.179, so you can put "139.179.\*.\*" to allow everybody in the Bilkent network. The IPs of Lab rooms in the B building start with 139.179 and the third part is the room number without the middle digit. For example, the pattern for Lab №202 would be "139.179.22.\*". 
![](/Screenshots/8.png)

And finally, you may find the scheme of the Lab room and the numbering of the PCs in the last field.  
![](/Screenshots/9.png)

## Notes
1)	It prevents students to stand in the queue if their pc is already in the queue.
2)	Average wait/grade times: Average wait time is the average time one should wait in the queue before getting graded by a TA. Average grade time shows the average time it takes TA to grade one student.
3)	Students and TAs should be able to include special characters in their names, for instance, Turkish characters.
4)	This application is very insecure since it saves all of the information in the /tmp folder. This folder can be deleted after reboot of the system. Also, this folder is available for everybody, so anybody can access it and change any information he/she wants. Since Bilkent University doesn`t provide any database for me, I couldn`t create a more secure application. Also, the server is not allowed to write information to the folder in which the application is located. The only option was to use the /tmp folder. Sorry about that.
5)	Since it\`s my first project, there may be some problems with the application. If you experience any problem or if you have any suggestion, please don\`t hesitate to contact me.

## Contact me
Ziya Mukhtarov

Bilkent University, 1st-year Computer Engineering student

ziya.mukhtarov@ug.bilkent.edu.tr
