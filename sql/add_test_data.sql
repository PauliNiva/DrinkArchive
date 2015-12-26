INSERT INTO Users(username, password, admin, last_login) VALUES
	('Admin', 'Salakala', true, now()),
	('Pauli', 'iluaP', false, now());

INSERT INTO DrinkType(drink_type_name) VALUES ('Cocktail');

INSERT INTO DrinkType(drink_type_name) VALUES ('Cooler');

INSERT INTO Ingredients(ingredient_name) VALUES('Whisky');

INSERT INTO Ingredients(ingredient_name) VALUES('Angostura');

INSERT INTO Ingredients(ingredient_name) VALUES('Sugar cube');

INSERT INTO Ingredients(ingredient_name) VALUES('Plain water');

INSERT INTO Drinks(drink_name, instructions, time_added, adder_id, drink_type) VALUES
	('Old Fashioned', 'Place sugar cube in old fashioned glass and saturate with bitters,
		 add a dash of plain water Muddle until dissolved. Fill the glass with ice cubes
		 and add whiskey. Garnish with orange slice, and a cocktail cherry.', 'NOW()',
		 (SELECT user_id FROM Users WHERE username = 'Admin'),
		 (SELECT drink_type_id FROM DrinkType WHERE drink_type_name = 'Cocktail'));

INSERT INTO DrinkIngredient(amount, unit, ingredient_id, drink_id) VALUES
	(4.5, 'cl', (SELECT ingredient_id FROM Ingredients WHERE ingredient_name = 'Whisky'),
		(SELECT drink_id FROM Drinks WHERE drink_name = 'Old Fashioned'));

INSERT INTO DrinkIngredient(amount, unit, ingredient_id, drink_id) VALUES
	(2, 'dashes', (SELECT ingredient_id FROM Ingredients WHERE ingredient_name = 'Angostura'),
		(SELECT drink_id FROM Drinks WHERE drink_name = 'Old Fashioned'));

INSERT INTO DrinkIngredient(amount, unit, ingredient_id, drink_id) VALUES
	(1, '', (SELECT ingredient_id FROM Ingredients WHERE ingredient_name = 'Sugar cube'),
		(SELECT drink_id FROM Drinks WHERE drink_name = 'Old Fashioned'));

INSERT INTO DrinkIngredient(amount, unit, ingredient_id, drink_id) VALUES
	(2, 'dashes', (SELECT ingredient_id FROM Ingredients WHERE ingredient_name = 'Plain water'),
		(SELECT drink_id FROM Drinks WHERE drink_name = 'Old Fashioned'));

INSERT INTO Favorites(user_id, drink_id) VALUES
	((SELECT user_id FROM Users WHERE username = 'Admin'),
		(SELECT drink_id FROM Drinks WHERE drink_name = 'Old Fashioned'));