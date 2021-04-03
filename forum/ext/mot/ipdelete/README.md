# IP Address Deletion

![Version: 1.0.2](https://img.shields.io/badge/Version-1.0.2-green)  
   
![phpBB 3.1.x Compatible](https://img.shields.io/badge/phpBB-3.1.x%20Compatible-009BDF)
![phpBB 3.2.x Compatible](https://img.shields.io/badge/phpBB-3.2.x%20Compatible-009BDF)
![phpBB 3.3.x Compatible](https://img.shields.io/badge/phpBB-3.3.x%20Compatible-009BDF)  

IP Address Deletion is an extension to the phpBB bulletin board software which ensures privacy and data protection by deleting user related IP addresses in all database tables original to phpBB when a user gets deleted.

## Description
There are countries where the IP address an internet user uses is assumed to belong to his/her personal data and thus falls under privacy and data protection laws. Especially the supreme court of the European Union ruled that a user has a right to be informed if the IP address from which he/she logs into a web site is stored and that he/she has a right to have this information deleted if the respective service is no longer used. This means that the IP address still stored within phpBB's database must be deleted if a user gets deleted.  
phpBB stores user IP addresses in several tables and explicitly within the posts table it is not deleted if a user gets deleted and his/her posts are retained. This is what `IP Address Deletion` does.  
To fulfill this task `IP Address Deletion` is hooked into phpBB's `delete_user` function via the `core.delete_user_before` event. Everytime a user is deleted it replaces IP Addresses stored with this user's `user_id` with an empty string to ensure that nowhere within the phpBB core tables the IP address is stored any longer.

## Note
`IP Address Deletion` has no settings and is not visible anywhere in the ACP. After having been successfully enabled it just works in the background. Its existence is only visible through its presence in the table listing the enabled and active extensions.
