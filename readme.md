Newton Car maintenance PHP assignment for iO campus Eindhoven job application


## Installation

1. Install Lando, if you haven't already. You can download it from [here](https://lando.dev/download/).
2. Clone the repository to your local machine.
3. Navigate to the project directory in your terminal.
4. Run `lando start` to start the services.
5. Once the services are up, you can access the site at the URL provided by Lando.
6. Migrate the databases.
7. Import the CSV's to fill the databases.

## List of assumptions

1. A Symfony 7 project chosen to make php code up to modern standard
2. Class diagram was also fully implemented, some changes and omissions were made:
   1. Additionals relationships were made to connect Brand and Model classes to the MaintenanceJob class. It was done to make sure that a MaintenanceJob can be either Brand or Model specific without requiring a SparePart class.
   2. Timeslot class was left out, seeing as it is irrelevant for the current assignemnt of calculate, a property where one can chose between "Weekdays" or "Weekends" is sufficient for the current calculation.
3. VAT values was assumed to be 21%.
4. ScheduledMaintenanceJob price breakdown is: Baseprice (sum of price of spare parts and maintenance job price), VAT price (21% of the Baseprice) and totalPrice (sum of basePrice and vatPrice).

## Note

To challenge myself, I choose to do this project in Symfony, which I had previously not worked in to also challenge myself in the aspect of learning a framework as much as possible in a short time.
The assigment is 95% complete, the real time connection of dynamics spare parts prices was not completed, but both Symfony project work as intended.


  




