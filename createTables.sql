use desafio;
create table ticket(
TicketID int primary key,
CategoryID int,
CustomerID int,
CustomerName varchar(140),
CustomerEmail varchar(140),
DateCreate datetime,
DateUpdate datetime,
Complaint boolean,
SentimentAverage double(4,2),
Priority varchar(20),
SLATimeHours int);

create table interaction (
IdInteraction int auto_increment,
TicketID int,
Subject varchar(140),
Message text,
DateCreate datetime,
Sender varchar(140),
Sentiment double(4,2),
Magnitude double(4,2),
PRIMARY KEY (IdInteraction),
FOREIGN KEY (TicketID) REFERENCES ticket(TicketID)
)