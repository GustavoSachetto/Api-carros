use cars_api;

select * from user;

select * from brand;

select * from model;

select * from fuel;

select * from transmission;

select * from vehicle;

select vehicle.*, model.name, model.brand_id,  brand.name, fuel.name, transmission.name from vehicle 
inner join model on vehicle.model_id = model.id
inner join brand on model.brand_id = brand.id
inner join fuel on vehicle.fuel_id = fuel.id
inner join transmission on vehicle.transmission_id = transmission.id where vehicle.id = 6;

select model.*, brand.name from model 
inner join brand on model.brand_id = brand.id;