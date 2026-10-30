-- Sample products for the shop. Run this AFTER update_schema.sql.
-- Safe to run again: it clears the products table first.
-- product_special_offer is a percentage discount (0 = no offer).
-- Images are files in assets/imgs (vegetables and fertilizer use photos,
-- machines and pesticides use the illustrations in assets/imgs/products).

DELETE FROM `products`;

INSERT INTO `products`
(`product_name`,`product_category`,`product_description`,`product_image`,`product_image2`,`product_image3`,`product_image4`,`product_price`,`product_special_offer`,`product_color`) VALUES
('Fresh Tomato','vegetable','Juicy, vine-ripened red tomatoes grown without harmful chemicals. Ideal for salads, curries and sauces. Price per kg.','tomato.jpg','tomato2.jpg','tomato3.jpg','tomato4.jpg',60.00,10,'red'),
('Fresh Carrot','vegetable','Crunchy, sweet carrots harvested fresh from the field. Rich in vitamin A. Price per kg.','carrot.jpg','carrot2.jpg','carrot3.jpg','carrot4.jpg',50.00,0,'orange'),
('Potato','vegetable','Firm, good quality potatoes that store well and suit every kind of cooking. Price per kg.','potato.jpg','potato2.jpg','potato3.jpg','potato4.png',35.00,0,'brown'),
('Capsicum','vegetable','Fresh, firm capsicum with a mild sweet flavour. Great for stir fries and salads. Price per kg.','capsicum.jpg','capsicum2.jpg','capsicum3.jpg','capsicum4.jpg',120.00,0,'green'),
('Broccoli','vegetable','Dark green, tight-headed broccoli packed with fibre and vitamins. Price per kg.','broccoli.jpg','broccoli.jpg','broccoli.jpg','broccoli.jpg',140.00,0,'green'),
('Green Chilli','vegetable','Fresh, spicy green chillies for everyday cooking. Price per kg.','chilli.jpg','chilli.jpg','chilli.jpg','chilli.jpg',160.00,0,'green'),
('Fresh Lettuce','vegetable','Crisp, leafy lettuce that is washed and ready to use. Price per kg.','ontario.jpg','ontario.jpg','ontario.jpg','ontario.jpg',90.00,0,'green'),

('Mini Tractor 20 HP','machine','Compact 20 HP tractor for small and medium farms. Easy to handle, fuel efficient and works with ploughs, tillers and trailers.','products/tractor.svg','products/tractor.svg','products/tractor.svg','products/tractor.svg',540000.00,0,'green'),
('Power Tiller','machine','Petrol-powered rotary tiller that prepares soil quickly. Adjustable handle and easy-start engine.','products/tiller.svg','products/tiller.svg','products/tiller.svg','products/tiller.svg',95000.00,0,'red'),
('Water Pump 3 HP','machine','Portable centrifugal pump for field irrigation, with strong suction and steady flow.','products/pump.svg','products/pump.svg','products/pump.svg','products/pump.svg',14500.00,0,'blue'),
('Knapsack Sprayer 16L','machine','16 litre backpack sprayer with padded straps and an adjustable nozzle. Suitable for pesticides and liquid fertilizer.','products/sprayer.svg','products/sprayer.svg','products/sprayer.svg','products/sprayer.svg',2800.00,15,'yellow'),

('Insecticide 500ml','pesticide','General purpose insecticide that controls aphids, borers and caterpillars on vegetable crops. Always follow the label instructions.','products/insecticide.svg','products/insecticide.svg','products/insecticide.svg','products/insecticide.svg',450.00,0,'red'),
('Fungicide 250g','pesticide','Controls blight, mildew and other fungal disease in vegetables and rice. Apply early for best results.','products/fungicide.svg','products/fungicide.svg','products/fungicide.svg','products/fungicide.svg',380.00,10,'blue'),
('Herbicide 1L','pesticide','Selective weed control for field crops. Clears broadleaf weeds without harming the main crop when used as directed.','products/herbicide.svg','products/herbicide.svg','products/herbicide.svg','products/herbicide.svg',620.00,0,'yellow'),

('NPK Fertilizer 5kg','fertilizer','Balanced nitrogen, phosphorus and potassium granules that boost early growth, flowering and yield.','exclusive3.jpg','exclusive3.jpg','exclusive3.jpg','exclusive3.jpg',1200.00,0,'blue'),
('Urea Fertilizer 50kg','fertilizer','High-nitrogen urea for leafy growth. A standard choice for rice, maize and vegetables.','products/urea.svg','products/urea.svg','products/urea.svg','products/urea.svg',1950.00,0,'green'),
('Oil Palm Seeds','fertilizer','Certified oil palm seeds with high germination rate for new plantations.','exclusive1.jpg','exclusive1.jpg','exclusive1.jpg','exclusive1.jpg',650.00,0,'red');
