-- Sample products so the shop is not empty. Prices are in BDT (max 9999.99).
-- Images are files in assets/imgs. Machine and pesticide rows reuse existing
-- images as placeholders; change product_image* later to real photos.

INSERT INTO `products`
(`product_name`,`product_category`,`product_description`,`product_image`,`product_image2`,`product_image3`,`product_image4`,`product_price`,`product_special_offer`,`product_color`) VALUES
('Fresh Tomato','vegetable','Fresh, farm-grown red tomatoes. Price per kg.','tomato.jpg','tomato2.jpg','tomato3.jpg','tomato4.jpg',60.00,0,'red'),
('Fresh Carrot','vegetable','Crunchy, sweet carrots straight from the field. Price per kg.','carrot.jpg','carrot2.jpg','carrot3.jpg','carrot4.jpg',50.00,0,'orange'),
('Potato','vegetable','Good quality potatoes for cooking and storage. Price per kg.','potato.jpg','potato2.jpg','potato3.jpg','potato4.png',35.00,0,'brown'),
('Capsicum','vegetable','Green capsicum, fresh and firm. Price per kg.','capsicum.jpg','capsicum2.jpg','capsicum3.jpg','capsicum4.jpg',120.00,0,'green'),
('Broccoli','vegetable','Fresh green broccoli. Price per kg.','broccoli.jpg','broccoli.jpg','broccoli.jpg','broccoli.jpg',140.00,0,'green'),
('Green Chilli','vegetable','Spicy green chillies. Price per kg.','chilli.jpg','chilli.jpg','chilli.jpg','chilli.jpg',160.00,0,'green'),
('Power Tiller','machine','Compact power tiller for small and medium farms.','exclusive1.jpg','exclusive1.jpg','exclusive1.jpg','exclusive1.jpg',9500.00,0,'red'),
('Hand Sprayer','machine','Knapsack sprayer for pesticides and fertilizer, 16 litre.','exclusive2.jpg','exclusive2.jpg','exclusive2.jpg','exclusive2.jpg',2200.00,0,'blue'),
('Seed Drill','machine','Manual seed drill for even planting.','exclusive3.jpg','exclusive3.jpg','exclusive3.jpg','exclusive3.jpg',4800.00,0,'green'),
('Irrigation Pump','machine','Portable water pump for field irrigation.','ontario.jpg','ontario.jpg','ontario.jpg','ontario.jpg',7800.00,0,'black'),
('Insecticide 500ml','pesticide','General purpose insecticide for vegetable crops.','brand1.png','brand1.png','brand1.png','brand1.png',450.00,0,'white'),
('Fungicide 250g','pesticide','Controls fungal disease in vegetables and rice.','brand2.png','brand2.png','brand2.png','brand2.png',380.00,0,'white'),
('Herbicide 1L','pesticide','Weed control for field crops.','brand3.png','brand3.png','brand3.png','brand3.png',620.00,0,'white'),
('Rapeseed Pesticide','pesticide','Protects rapeseed crops from common pests.','rapeseed.png','rapeseed.png','rapeseed.png','rapeseed.png',520.00,0,'white');
