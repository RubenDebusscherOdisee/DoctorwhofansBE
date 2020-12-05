ALTER TABLE `api__writers` 
ADD `API__writers__Owner__ID` INT NOT NULL AFTER `name`, 
ADD `API__writers__Created` TIMESTAMP NOT NULL DEFAULT CURRENT_TIMESTAMP AFTER `API__writers__Owner__ID`, 
ADD `API__writers__Last__Modified__User__ID` INT NOT NULL AFTER `API__writers__Created`, 
ADD `API__writers__Last__Modified` TIMESTAMP on update CURRENT_TIMESTAMP NOT NULL DEFAULT CURRENT_TIMESTAMP AFTER `API__writers__Last__Modified__User__ID`;

UPDATE `api__writers` SET `API__writers__Owner__ID`=1,`API__writers__Last__Modified__User__ID`=1;

ALTER TABLE `api__writers` ADD FOREIGN KEY (`API__writers__Owner__ID`) REFERENCES `users`(`User__Id`) ON DELETE RESTRICT ON UPDATE RESTRICT; 
ALTER TABLE `api__writers` ADD FOREIGN KEY (`API__writers__Last__Modified__User__ID`) REFERENCES `users`(`User__Id`) ON DELETE RESTRICT ON UPDATE NO ACTION;