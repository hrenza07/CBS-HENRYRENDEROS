Here is the code that I made for the following exercise:
Just complete Stage 1

Stage 1:
	Present a UI view which has several components:
[DONE]	A form to send a text message. This should have a To (phone number, or a list of phone numbers), and a message
[DONE]	A button to send the form, and some validation would be nice.
[DONE]	A list of previously sent text messages with column headers. Sortable would be nice.
[DONE]	The UI view should connect to a SQL Server database, with two tables:
[DONE]	One table for the messages
[DONE]	Id primary key
[DONE]	Date / Time created
[DONE]	To field
[DONE]	Message field
[DONE]	One table for the sending of the messages
[DONE]	Id primary key
[DONE]	Foreign Key to the messages Id
[DONE]	Date / Time sent
[DONE]	Confirmation code from Twilio
[DONE]	When the user clicks the button to send the form, it should store in the database table.

Stage 2:
[I create a free account and download all the sources]

Using the Twilio API, send out a message
Likely should store the Twilio credentials somewhere, not in the code … a database table, or a file, or a build property
When the user clicks the button to send the form, it should store in the database table AND send a text message to Twilio
The response back from Twilio should be stored in the database table

Stage 3:

The response back from Twilio should be stored in the database table AND should be shown in the UI
Where appropriate, please abstract the storage of the data into the appropriate classes / architecture. Our main code base has well over 1,000,000 lines of code, so we need to make sure there’s clear code abstraction even if it’s a small amount of code.

Please use the appropriate Entity Framework objects / etc.… and if you’re familiar with TDD or BDD, feel free to include those tests. If you normally use logging, please tie that in as well.

If you have any questions or need any clarification, please let me know. Again, the goal is to understand how you work and how we might work together.