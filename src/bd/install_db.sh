#!/bin/bash

#USAGE ./install_db.sh MYSQL_HOST MYSQL_USERNAME
#EXEMPLE ./install_db.sh localchost root

db_host=$1
db_user=$2

CREATE_DATABASE="CREATE DATABASE scma;"
CREATE_USER_TABLE="CREATE TABLE Users (id SMALLINT NOT NULL AUTO_INCREMENT PRIMARY KEY,
						login VARCHAR(64) NOT NULL,
						password VARCHAR(64) NOT NULL,
						pseudo VARCHAR(64) NOT NULL,
						email VARCHAR(64) NOT NULL);"
CREATE_PROJECT_TABLE="CREATE TABLE Project (id SMALLINT NOT NULL AUTO_INCREMENT PRIMARY KEY,
						title VARCHAR(64) NOT NULL,
						scrummaster SMALLINT NOT NULL,
						FOREIGN KEY (scrummaster)
							REFERENCES Users(id)
							ON DELETE CASCADE,
						productowner SMALLINT NOT NULL,
						FOREIGN KEY (productowner)
							REFERENCES Users(id)
							ON DELETE CASCADE,
						description TEXT);"
CREATE_CONTRIBUTORPROJECT_TABLE="CREATE TABLE ContributorProject (contributor SMALLINT NOT NULL,
						project SMALLINT NOT NULL,
						FOREIGN KEY (contributor)
							REFERENCES Users(id)
							ON DELETE CASCADE,
						FOREIGN KEY (project)
							REFERENCES Project(id)
							ON DELETE CASCADE,
						PRIMARY KEY(contributor, project));"

CREATE_USERSTORY_TABLE="CREATE TABLE UserStory (id SMALLINT NOT NULL AUTO_INCREMENT PRIMARY KEY,
						project SMALLINT NOT NULL,
						FOREIGN KEY (project)
							REFERENCES Project(id)
							ON DELETE CASCADE,	
						rank VARCHAR(32) NOT NULL,
						action VARCHAR(32) NOT NULL,
						goal VARCHAR(32) NOT NULL,
						priority SMALLINT,
						difficulty SMALLINT NOT NULL);"

CREATE_SPRINT_TABLE="CREATE TABLE Sprint (id SMALLINT NOT NULL AUTO_INCREMENT PRIMARY KEY,
						number SMALLINT NOT NULL,
						project SMALLINT NOT NULL,
						FOREIGN KEY (project)
							REFERENCES Project(id)
							ON DELETE CASCADE,
						start DATE NOT NULL,
						end DATE NOT NULL);"

CREATE_TASK_TABLE="CREATE TABLE Task (id SMALLINT NOT NULL AUTO_INCREMENT PRIMARY KEY,
						project SMALLINT NOT NULL,
						FOREIGN KEY (project)
							REFERENCES Project(id)
							ON DELETE CASCADE,						
						description TEXT,
						effort SMALLINT,
						sprint SMALLINT,
						FOREIGN KEY (sprint)
							REFERENCES Sprint(id)
							ON DELETE CASCADE,
						state TINYINT NOT NULL);"

CREATE_CONTRIBUTORTASK_TABLE="CREATE TABLE ContributorTask (contributor SMALLINT NOT NULL,
						task SMALLINT NOT NULL,
						FOREIGN KEY (contributor)
							REFERENCES Users(id)
							ON DELETE CASCADE,
						FOREIGN KEY (task)
							REFERENCES Task(id)
							ON DELETE CASCADE,
						PRIMARY KEY(contributor, Task));"

CREATE_ANNEX_TABLE="CREATE TABLE Annexe (id SMALLINT NOT NULL AUTO_INCREMENT PRIMARY KEY,
						project SMALLINT NOT NULL,
						FOREIGN KEY (project)
							REFERENCES Project(id)
							ON DELETE CASCADE,
						name VARCHAR(32) NOT NULL,
						type VARCHAR(32) NOT NULL);"

echo $CREATE_DATABASE > tmp.sql
echo "USE scma;" >> tmp.sql
echo $CREATE_USER_TABLE >> tmp.sql
echo $CREATE_PROJECT_TABLE >> tmp.sql
echo $CREATE_USERSTORY_TABLE >> tmp.sql
echo $CREATE_SPRINT_TABLE >> tmp.sql
echo $CREATE_TASK_TABLE >> tmp.sql
echo $CREATE_CONTRIBUTORPROJECT_TABLE >> tmp.sql
echo $CREATE_CONTRIBUTORTASK_TABLE >> tmp.sql
echo $CREATE_ANNEXE_TABLE >> tmp.sql

mysql -u$db_user -p -h$db_host < tmp.sql

rm tmp.sql