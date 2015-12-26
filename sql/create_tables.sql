CREATE TABLE Users (
user_id SERIAL PRIMARY KEY,
username VARCHAR(32) UNIQUE NOT NULL,
password VARCHAR(32) NOT NULL,
admin BOOLEAN,
last_login TIMESTAMPTZ
);

CREATE TABLE DrinkType (
drink_type_id SERIAL PRIMARY KEY,
drink_type_name VARCHAR(32) UNIQUE NOT NULL
);

CREATE TABLE Ingredients (
ingredient_id SERIAL PRIMARY KEY,
ingredient_name VARCHAR(32) UNIQUE NOT NULL
);

CREATE TABLE Drinks (
drink_id SERIAL PRIMARY KEY,
drink_name VARCHAR(32) UNIQUE NOT NULL,
instructions VARCHAR(2048),
time_added TIMESTAMPTZ NOT NULL,
adder_id INTEGER REFERENCES Users(user_id)
	ON DELETE SET NULL
	ON UPDATE CASCADE ,
drink_type INTEGER REFERENCES DrinkType(drink_type_id)
);

CREATE TABLE DrinkIngredient (
amount DECIMAL(4,1),
unit VARCHAR(16),
ingredient_id INTEGER REFERENCES Ingredients(ingredient_id)
	ON DELETE CASCADE
	ON UPDATE CASCADE,
drink_id INTEGER REFERENCES Drinks(drink_id)
	ON DELETE CASCADE
	ON UPDATE CASCADE
);

CREATE TABLE Favorites (
	user_id INTEGER REFERENCES Users(user_id) ON DELETE CASCADE,
	drink_id INTEGER REFERENCES Drinks(drink_id) ON DELETE CASCADE,
	PRIMARY KEY(user_id, drink_id)
);