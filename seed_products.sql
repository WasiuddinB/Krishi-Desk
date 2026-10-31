-- Sample products for the shop. Run this AFTER update_schema.sql (or tables.sql on a fresh database).
-- Safe to run again: it clears the products table first.
--
-- product_special_offer is a percentage discount (0 = no offer).
-- Images live in assets/imgs/products. Each product has ONE photo to start with;
-- see IMAGES.md for how to add more angles to a product's gallery.
-- Descriptions are deliberately plain. Add manufacturer, model and specification
-- details (and label information for pesticides and fertilizers) from the real supplier.

DELETE FROM `products`;

INSERT INTO `products`
(`product_name`,`product_category`,`product_description`,`product_image`,`product_image2`,`product_image3`,`product_image4`,`product_price`,`product_special_offer`,`product_color`) VALUES
('Fresh Tomato','vegetable','Fresh tomatoes sold by the kilogram. Good for salads, curries and sauces.','products/tomato.jpg','products/tomato.jpg','products/tomato.jpg','products/tomato.jpg',60.00,10,'red'),
('Fresh Carrot','vegetable','Fresh carrots sold by the kilogram.','products/carrot.jpg','products/carrot.jpg','products/carrot.jpg','products/carrot.jpg',50.00,0,'orange'),
('Potato','vegetable','Potatoes sold by the kilogram, for everyday cooking.','products/potato.jpg','products/potato.jpg','products/potato.jpg','products/potato.jpg',35.00,0,'brown'),
('Capsicum','vegetable','Fresh capsicum sold by the kilogram.','products/capsicum.jpg','products/capsicum.jpg','products/capsicum.jpg','products/capsicum.jpg',120.00,0,'green'),
('Broccoli','vegetable','Fresh broccoli sold by the kilogram.','products/broccoli.jpg','products/broccoli.jpg','products/broccoli.jpg','products/broccoli.jpg',140.00,0,'green'),
('Green Chilli','vegetable','Fresh green chillies sold by the kilogram.','products/green-chilli.jpg','products/green-chilli.jpg','products/green-chilli.jpg','products/green-chilli.jpg',160.00,0,'green'),
('Fresh Lettuce','vegetable','Fresh lettuce sold by the kilogram.','products/lettuce.jpg','products/lettuce.jpg','products/lettuce.jpg','products/lettuce.jpg',90.00,0,'green'),

('Mini Tractor 20 HP','machine','Compact 20 HP tractor for small and medium farms.','products/mini-tractor.jpg','products/mini-tractor.jpg','products/mini-tractor.jpg','products/mini-tractor.jpg',540000.00,0,'green'),
('Power Tiller','machine','Petrol-powered rotary tiller for preparing soil on small plots.','products/power-tiller.jpg','products/power-tiller.jpg','products/power-tiller.jpg','products/power-tiller.jpg',95000.00,0,'red'),
('Water Pump 3 HP','machine','Portable 3 HP water pump for field irrigation.','products/water-pump.jpg','products/water-pump.jpg','products/water-pump.jpg','products/water-pump.jpg',14500.00,0,'blue'),
('Knapsack Sprayer 16L','machine','16 litre backpack sprayer with an adjustable nozzle.','products/knapsack-sprayer.jpg','products/knapsack-sprayer.jpg','products/knapsack-sprayer.jpg','products/knapsack-sprayer.jpg',2800.00,15,'yellow'),

('Insecticide 500ml','pesticide','General purpose insecticide, 500 ml pack. Read the label and follow the manufacturer''s instructions before use.','products/insecticide.jpg','products/insecticide.jpg','products/insecticide.jpg','products/insecticide.jpg',450.00,0,'red'),
('Fungicide 250g','pesticide','Fungicide, 250 g pack. Read the label and follow the manufacturer''s instructions before use.','products/fungicide.jpg','products/fungicide.jpg','products/fungicide.jpg','products/fungicide.jpg',380.00,10,'blue'),
('Herbicide 1L','pesticide','Herbicide, 1 litre pack. Read the label and follow the manufacturer''s instructions before use.','products/herbicide.jpg','products/herbicide.jpg','products/herbicide.jpg','products/herbicide.jpg',620.00,0,'yellow'),

('NPK Fertilizer 5kg','fertilizer','Compound NPK fertilizer, 5 kg pack. Follow the application rate on the pack.','products/npk-fertilizer.jpg','products/npk-fertilizer.jpg','products/npk-fertilizer.jpg','products/npk-fertilizer.jpg',1200.00,0,'blue'),
('Urea Fertilizer 50kg','fertilizer','Urea fertilizer, 50 kg bag. Follow the application rate on the bag.','products/urea-fertilizer.jpg','products/urea-fertilizer.jpg','products/urea-fertilizer.jpg','products/urea-fertilizer.jpg',1950.00,0,'green'),
('Oil Palm Seeds','fertilizer','Oil palm seeds for plantation use.','products/oil-palm-seeds.jpg','products/oil-palm-seeds.jpg','products/oil-palm-seeds.jpg','products/oil-palm-seeds.jpg',650.00,0,'red');
