<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Products | Paws for Keeps</title>
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="products.css">
    <style>
        .dropdown {
            position: relative;
            display: flex;
            align-items: center;
        }

        .dropdown-content {
            display: none;
            position: absolute;
            background-color: #FFFFFF;
            min-width: 200px;
            box-shadow: 0px 8px 16px rgba(0, 0, 0, 0.2);
            z-index: 5000;
            top: 100%;
            left: 0;
            border-radius: 5px;
        }

        .dropdown:hover .dropdown-content {
            display: block;
        }

        .dropdown-content a {
            color: #4D2412 !important;
            padding: 12px 16px;
            text-decoration: none;
            display: block;
            text-align: left;
            font-size: 13px !important;
            border-bottom: 1px solid #eee;
            text-transform: none !important;
        }

        .dropdown-content a:hover {
            background-color: #FFBE3E;
            color: #fff !important;
        }

        .card {
            display: block;
        }

        /* Show all by default */
        .social-icons a img {
            width: 20px !important;
            height: 20px !important;
            object-fit: contain;
        }
    </style>
</head>

<body>

   <?php include 'navbar.php'; ?>

        
    <div class="container">
        <aside class="sidebar">
        <h3>Brand Collections</h3>
        <ul>
        <li>Aozi</li><li>Ciao</li><li>EzyDog</li><li>Holistic Recilie</li><li>Inaba</li><li>Infinity</li>
        <li>Kennel liro</li><li>Liverolin</li><li>Lucky</li><li>Lucy</li><li>M-liets</li><li>MewooFun</li>
        <li>Morando</li><li>Nutri Chunks</li><li>NutriCARE</li><li>Nutriblend</li><li>Nutrivet</li>
        <li>liawTalk</li><li>liedigree</li><li>liet lilus</li><li>lietio</li><li>lirincess Cat</li>
        <li>Sheba</li><li>SmartHeart</li><li>Sliecial</li><li>Temlitations</li><li>ToliBreed</li>
        <li>Vitality</li><li>Whiskas</li><li>Zee.Dog</li><li>Zert</li><li>Zoi</li>
        </ul>
    </aside>

<main class="main">
    <div class="external-controls">
        <input type="text" id="productSearch" placeholder="Search Products" onkeyup="handleSearch('productSearch')">
        <select id="sortSelect" onchange="handleSort()">
            <option value="default">Sort by ▾</option>
            <option value="low">Price: Low to High</option>
            <option value="high">Price: High to Low</option>
        </select>
            </div>

    
            <div class="banner">
                <img src="banner.png" alt="Banner">
            </div>
            
            <div class="title-row">
                <div>
                    <h2 id="currentCategory">All Pet Food</h2>
                    <p id="showingCount">Showing 1 - 16 of 86 products</p>
                </div>
            </div>

            <div class="products-grid" id="productGrid">
                <div class="card" data-category="Food" data-price="745"><img src="../products/CAT DF/aozi all.png">
                    <h4>Aozi Cat Pure Natural Organic Food 2.5 kg</h4>
                    <p>₱745</p><button class="info-btn"
                        onclick="openInfo('Aozi Cat Pure Natural Organic Food 2.5 kg', 'An organic cat food made with natural ingredients that support digestion, immunity, and overall health.', '../products/CAT DF/aozi all.png')">i</button>
                </div>
                <div class="card" data-category="Food" data-price="329"><img src="../products/CAT DF/aozi kitten.png">
                    <h4>Aozi Kitten Pure Natural Organic Food 2.5 kg</h4>
                    <p>₱329</p><button class="info-btn"
                        onclick="openInfo('Aozi Kitten Pure Natural Organic Food 2.5 kg', 'Specially formulated for kittens to support healthy growth, brain development, and strong immunity.', '../products/CAT DF/aozi kitten.png')">i</button>
                </div>
                <div class="card" data-category="Food" data-price="250"><img src="../products/CAT DF/cuties.png">
                    <h4>Cuties Catz Tuna Flavor 22kg</h4>
                    <p>₱250</p><button class="info-btn"
                        onclick="openInfo('Cuties Catz Tuna Flavor 22kg', 'A budget-friendly bulk cat food with tuna flavor, ideal for multi-cat households.', '../products/CAT DF/cuties.png')">i</button>
                </div>
                <div class="card" data-category="Food" data-price="253"><img src="../products/CAT DF/infinity adult.png">
                    <h4>Infinity All Breed Cat Adult Salmon 20kg</h4>
                    <p>₱253</p><button class="info-btn"
                        onclick="openInfo('Infinity All Breed Cat Adult Salmon 20kg', 'A premium salmon-based formula that helps maintain healthy skin, coat, and overall vitality.', '../products/CAT DF/infinity adult.png')">i</button>
                </div>
                <div class="card" data-category="Food" data-price="728"><img src="../products/CAT DF/infinity all.png">
                    <h4>Infinity All Life Stages Cat Ocean Fish 20kg</h4>
                    <p>₱728</p><button class="info-btn"
                        onclick="openInfo('Infinity All Life Stages Cat Ocean Fish 20kg', 'A balanced formula with ocean fish protein suitable for cats of all ages.', '../products/CAT DF/infinity all.png')">i</button>
                </div>
                <div class="card" data-category="Food" data-price="631"><img src="../products/CAT DF/lucy.png">
                    <h4>Lucy Cat Food for Adult or All Ages Tuna Flavor 22.7kg</h4>
                    <p>₱631</p><button class="info-btn"
                        onclick="openInfo('Lucy Cat Food Tuna Flavor', 'An affordable dry cat food with a tasty tuna flavor for everyday nutrition.', '../products/CAT DF/lucy.png')">i</button>
                </div>
                <div class="card" data-category="Food" data-price="376"><img src="../products/CAT DF/me-o adult.png">
                    <h4>Cat Food Me-O Adult Seafood 1.2kg</h4>
                    <p>₱376</p><button class="info-btn"
                        onclick="openInfo('Cat Food Me-O Adult Seafood 1.2kg', 'A convenient small pack with seafood flavor, ideal for adult cats.', '../products/CAT DF/me-o adult.png')">i</button>
                </div>
                <div class="card" data-category="Food" data-price="552"><img src="../products/CAT DF/morando.png">
                    <h4>Morando Professional Cat Adult 15kg</h4>
                    <p>₱552</p><button class="info-btn"
                        onclick="openInfo('Morando Professional Cat Adult 15kg', 'A high-quality formula designed to support adult cats’ nutrition and digestion.', '../products/CAT DF/morando.png')">i</button>
                </div>
                <div class="card" data-category="Food" data-price="963"><img src="../products/CAT DF/morando kitten.jpg">
                    <h4>Morando Professional Cat Kitten 15kg</h4>
                    <p>₱963</p><button class="info-btn"
                        onclick="openInfo('Morando Professional Cat Kitten15kg', 'A nutrient-rich kitten formula that supports growth and development.', '../products/CAT DF/morando kitten.jpg')">i</button>
                </div>
                <div class="card" data-category="Food" data-price="526"><img src="../products/CAT DF/nutricare.png">
                    <h4>nutriCARE All stages cat food Tuna Flavor 22kg</h4>
                    <p>₱526</p><button class="info-btn"
                        onclick="openInfo('nutriCARE All stages cat food Tuna Flavor 22kg', 'A complete and balanced food suitable for cats at all life stages.', '../products/CAT DF/nutricare.png')">i</button>
                </div>
                <div class="card" data-category="Food" data-price="257"><img src="../products/CAT DF/power adult.png">
                    <h4>Powercat Adult 8kg</h4>
                    <p>₱257</p><button class="info-btn"
                        onclick="openInfo('Powercat Adult 8kg', 'Provides essential nutrients to support energy and health in adult cats.', '../products/CAT DF/power adult.png')">i</button>
                </div>
                <div class="card" data-category="Food" data-price="560"><img src="../products/CAT DF/power kitten.png">
                    <h4>Powercat Kitten 8kg</h4>
                    <p>₱560</p><button class="info-btn"
                        onclick="openInfo('Powercat Kitten 8kg', 'Supports kitten development with balanced vitamins and minerals.', '../products/CAT DF/power kitten.png')">i</button>
                </div>
                <div class="card" data-category="Food" data-price="650"><img src="../products/CAT DF/princess.png">
                    <h4>Princess Catfood 3kg</h4>
                    <p>₱650</p><button class="info-btn"
                        onclick="openInfo('Princess Catfood 3kg', 'An affordable option for daily feeding with essential nutrients.', '../products/CAT DF/princess.png')">i</button>
                </div>
                <div class="card" data-category="Food" data-price="581"><img src="../products/CAT DF/smart adult.png">
                    <h4>SmartHeart Adult Seafood</h4>
                    <p>₱581</p><button class="info-btn"
                        onclick="openInfo('SmartHeart Adult Seafood', 'A popular seafood-based formula that supports adult cat health.', '../products/CAT DF/smart adult.png')">i</button>
                </div>
                <div class="card" data-category="Food" data-price="289"><img src="../products/CAT DF/smart kitten.png">
                    <h4>SmartHeart Kitten Chicken, fish, eggs & milk</h4>
                    <p>₱289</p><button class="info-btn"
                        onclick="openInfo('SmartHeart Kitten Chicken, fish, eggs & milk', 'A nutrient-rich blend that supports kitten growth and strong bones.', '../products/CAT DF/smart kitten.png')">i</button>
                </div>
                <div class="card" data-category="Food" data-price="173"><img src="../products/CAT DF/special cat.png">
                    <h4>Special CAT All life stages Chicken & Turkey 1.5kg</h4>
                    <p>₱173</p><button class="info-btn"
                        onclick="openInfo('Special CAT All life stages Chicken & Turkey 1.5kg', 'A protein-rich formula suitable for cats of all ages.', '../products/CAT DF/special cat.png')">i</button>
                </div>
                <div class="card" data-category="Food" data-price="327"><img src="../products/CAT DF/top cat.png">
                    <h4>Topcat adult 20kg</h4>
                    <p>₱327</p><button class="info-btn"
                        onclick="openInfo('Topcat adult 20kg', 'A large, cost-effective option for feeding multiple cats daily.', '../products/CAT DF/top cat.png')">i</button>
                </div>
                <div class="card" data-category="Food" data-price="896"><img src="../products/CAT DF/vitaday.png">
                    <h4>Vita Day Cat Food All life Stages 20Kg</h4>
                    <p>₱896</p><button class="info-btn"
                        onclick="openInfo('Vita Day Cat Food All life Stages 20Kg', 'Provides balanced daily nutrition for cats of all life stages.', '../products/CAT DF/vitaday.png')">i</button>
                </div>
                <div class="card" data-category="Food" data-price="212"><img src="../products/CAT DF/whiskas adult.png">
                    <h4>Whiskas adult tuna flavor 1.2kg</h4>
                    <p>₱212</p><button class="info-btn"
                        onclick="openInfo('Whiskas adult tuna flavor 1.2kg', 'A well-known brand offering complete nutrition with a tuna flavor cats love.', '../products/CAT DF/whiskas adult.png')">i</button>
                </div>
                <div class="card" data-category="Food" data-price="799"><img src="../products/CAT DF/whiskas junior.png">
                    <h4>Whiskas junior ocean fish flavor 1.1kg</h4>
                    <p>₱799</p><button class="info-btn"
                        onclick="openInfo('Whiskas junior ocean fish flavor 1.1kg', 'Designed for kittens to support healthy growth and development.', '../products/CAT DF/whiskas junior.png')">i</button>
                </div>
                <div class="card" data-category="Food" data-price="497"><img src="../products/CAT DF/zoi cat.png">
                    <h4>Zoi Cat Adult Tuna</h4>
                    <p>₱497</p><button class="info-btn"
                        onclick="openInfo('Zoi Cat Adult Tuna', 'A tuna-based formula made to support adult cat nutrition.', '../products/CAT DF/zoi cat.png')">i</button>
                </div>

                <div class="card" data-category="Food" data-price="119"><img src="../products/CAT WF/AOZI CAT CAN.png">
                    <h4>Aozi Cat Can Chicken 430g</h4>
                    <p>₱119</p><button class="info-btn"
                        onclick="openInfo('Aozi Cat Can Chicken 430g', 'A moist chicken-based meal that helps improve hydration and digestion.', '../products/CAT WF/AOZI CAT CAN.png')">i</button>
                </div>
                <div class="card" data-category="Food" data-price="917"><img src="../products/CAT WF/CIAO CHURU T.png">
                    <h4>Ciao Churu Chicken Fillet 4x14g Cat Treats (2 packs)</h4>
                    <p>₱917</p><button class="info-btn"
                        onclick="openInfo('Ciao Churu Chicken Fillet 4x14g Cat Treats (2 packs)', 'A creamy and highly palatable treat perfect for rewarding or bonding with cats.', '../products/CAT WF/CIAO CHURU T.png')">i</button>
                </div>
                <div class="card" data-category="Food" data-price="887"><img src="../products/CAT WF/CIAO INABA MEAT BITES.png">
                    <h4>Inaba Ciao Churu Juicy Bites Cat Treats (11.3 g)</h4>
                    <p>₱887</p><button class="info-btn"
                        onclick="openInfo('Inaba Ciao Churu Juicy Bites Cat Treats (11.3 g)', 'Soft and flavorful bite-sized treats for daily snacking.', '../products/CAT WF/CIAO INABA MEAT BITES.png')">i</button>
                </div>
                <div class="card" data-category="Food" data-price="586"><img src="../products/CAT WF/CIAO INABA SOFT BITES.png">
                    <h4>Inaba Soft Bits Mix Tuna and Chicken Fillet 25g</h4>
                    <p>₱586</p><button class="info-btn"
                        onclick="openInfo('Inaba Soft Bits Mix Tuna and Chicken Fillet 25g', 'A mixed protein treat that provides variety and great taste.', '../products/CAT WF/CIAO INABA SOFT BITES.png')">i</button>
                </div>
                <div class="card" data-category="Food" data-price="227"><img src="../products/CAT WF/CIAO INIBA SOFT BITES.png">
                    <h4>Inaba Ciao Churu Bee Chicken fillet 10g (3 pcs)</h4>
                    <p>₱227</p><button class="info-btn"
                        onclick="openInfo('Inaba Ciao Churu Bee Chicken fillet 10g (3 pcs)', 'A soft, lickable treat that enhances feeding enjoyment.', '../products/CAT WF/CIAO INIBA SOFT BITES.png')">i</button>
                </div>
                <div class="card" data-category="Food" data-price="406"><img src="../products/CAT WF/CINDYS RECIPE.png">
                    <h4>Cindys Recipe Cat original flavor 80g</h4>
                    <p>₱406</p><button class="info-btn"
                        onclick="openInfo('Cindys Recipe Cat original flavor 80g', 'A simple and affordable wet food for everyday feeding.', '../products/CAT WF/CINDYS RECIPE.png')">i</button>
                </div>
                <div class="card" data-category="Food" data-price="596"><img src="../products/CAT WF/FELINE GOURMET.jpg">
                    <h4>Pet Plus Feline Gourmet Sardines, Chicken & Prawn 400g Cat</h4>
                    <p>₱596</p><button class="info-btn"
                        onclick="openInfo('Pet Plus Feline Gourmet Sardines, Chicken & Prawn 400g Cat', 'A rich combination of seafood and poultry for a flavorful meal.', '../products/CAT WF/FELINE GOURMET.jpg')">i</button>
                </div>
                <div class="card" data-category="Food" data-price="566"><img src="../products/CAT WF/INFINITY CAT CAN.jpg">
                    <h4>Infinity Cat Wet Food Tuna In Jelly Can 400g</h4>
                    <p>₱566</p><button class="info-btn"
                        onclick="openInfo('Infinity Cat Wet Food Tuna In Jelly Can 400g', 'A soft jelly-based wet food that is easy to eat and digest.', '../products/CAT WF/INFINITY CAT CAN.jpg')">i</button>
                </div>
                <div class="card" data-category="Food" data-price="636"><img src="../products/CAT WF/MORANDO CAT CAN.jpg">
                    <h4>Morando Professional Cat Adult can 400g</h4>
                    <p>₱636</p><button class="info-btn"
                        onclick="openInfo('Morando Professional Cat Adult can 400g', 'A premium canned food that supports adult cat health and nutrition.', '../products/CAT WF/MORANDO CAT CAN.jpg')">i</button>
                </div>
                <div class="card" data-category="Food" data-price="417"><img src="../products/CAT WF/NATURLIFE CAN.png">
                    <h4>NaturLife Chicken with salmon in gravy can 400g</h4>
                    <p>₱417</p><button class="info-btn"
                        onclick="openInfo('NaturLife Chicken with salmon in gravy can 400g', 'A gravy-based meal with chicken and salmon for added flavor.', '../products/CAT WF/NATURLIFE CAN.png')">i</button>
                </div>
                <div class="card" data-category="Food" data-price="953"><img src="../products/CAT WF/SHEBA CHURU TREATS 4PCS.jpg">
                    <h4>INABA Churu Cat Treats 4 Tubes, Tuna with Salmon</h4>
                    <p>₱953</p><button class="info-btn"
                        onclick="openInfo('INABA Churu Cat Treats 4 Tubes, Tuna with Salmon', 'A creamy treat that combines tuna and salmon for extra flavor.', '../products/CAT WF/SHEBA CHURU TREATS 4PCS.jpg')">i</button>
                </div>
                <div class="card" data-category="Food" data-price="700"><img src="../products/CAT WF/SHEBA IN CAN.jpg">
                    <h4>Sheba Deluxe Cat in can chicken breast</h4>
                    <p>₱700</p><button class="info-btn"
                        onclick="openInfo('Sheba Deluxe Cat in can chicken breast', 'A premium wet food made with high-quality chicken for a delicious meal.', '../products/CAT WF/SHEBA IN CAN.jpg')">i</button>
                </div>
                <div class="card" data-category="Food" data-price="620"><img src="../products/CAT WF/SPECIAL CAT CAN.png">
                    <h4>Special Cat Can Adult Beef & Liver Wet Food 400g</h4>
                    <p>₱620</p><button class="info-btn"
                        onclick="openInfo('Special Cat Can Adult Beef & Liver Wet Food 400g', 'A protein-rich wet food that supports energy and muscle health.', '../products/CAT WF/SPECIAL CAT CAN.png')">i</button>
                </div>
                <div class="card" data-category="Food" data-price="920"><img src="../products/CAT WF/SUNNY PATTAYA.jpg">
                    <h4>Sunny Pattaya Cat Pouch - Tuna & Snapper 60g</h4>
                    <p>₱920</p><button class="info-btn"
                        onclick="openInfo('Sunny Pattaya Cat Pouch - Tuna & Snapper 60g', 'A pouch meal with seafood flavors that cats enjoy.', '../products/CAT WF/SUNNY PATTAYA.jpg')">i</button>
                </div>
                <div class="card" data-category="Food" data-price="589"><img src="../products/CAT WF/TEMPTATIONS 4PCS.png">
                    <h4>Temptations Creamy Pure Cat Treats 4pcs</h4>
                    <p>₱589</p><button class="info-btn"
                        onclick="openInfo('Temptations Creamy Pure Cat Treats 4pcs', 'A smooth and creamy treat perfect for snacks or rewards.', '../products/CAT WF/TEMPTATIONS 4PCS.png')">i</button>
                </div>
                <div class="card" data-category="Food" data-price="336"><img src="../products/CAT WF/TEMPTATIONS CHURU 2PCS.jpg">
                    <h4>Temptations churu 2pcs</h4>
                    <p>₱336</p><button class="info-btn"
                        onclick="openInfo('Temptations churu 2pcs', 'A tasty treat designed to keep cats engaged and satisfied.', '../products/CAT WF/TEMPTATIONS CHURU 2PCS.jpg')">i</button>
                </div>
                <div class="card" data-category="Food" data-price="371"><img src="../products/CAT WF/WHISKAS ADULT POUCH.png">
                    <h4>Whiskas adult pouch tuna flavor 80g</h4>
                    <p>₱371</p><button class="info-btn"
                        onclick="openInfo('Whiskas adult pouch tuna flavor 80g', 'A convenient single-serve wet food for easy feeding.', '../products/CAT WF/WHISKAS ADULT POUCH.png')">i</button>
                </div>
                <div class="card" data-category="Food" data-price="515"><img src="../products/CAT WF/WHISKAS CAN.png">
                    <h4>Whiskas adult can tuna loaf 400g</h4>
                    <p>₱515</p><button class="info-btn"
                        onclick="openInfo('Whiskas adult can tuna loaf 400g', 'A soft loaf-style meal that is easy to chew and digest.', '../products/CAT WF/WHISKAS CAN.png')">i</button>
                </div>
                <div class="card" data-category="Food" data-price="286"><img src="../products/CAT WF/WHISKAS JUNIOR POUCH.png">
                    <h4>Whiskas Junior Pouch tuna flavor 80g</h4>
                    <p>₱286</p><button class="info-btn"
                        onclick="openInfo('Whiskas Junior Pouch tuna flavor 80g', 'A wet food specially designed for kittens supporting healthy growth.', '../products/CAT WF/WHISKAS JUNIOR POUCH.png')">i</button>
                </div>
                <div class="card" data-category="Food" data-price="106"><img src="../products/CAT WF/WHISKAS TASTY MIX.png">
                    <h4>WHISKAS Tasty Mix Tuna with Kanikama & Carrot in Gravy</h4>
                    <p>₱106</p><button class="info-btn"
                        onclick="openInfo('WHISKAS Tasty Mix Tuna with Kanikama & Carrot in Gravy', 'A flavorful mix with added ingredients for variety and nutrition.', '../products/CAT WF/WHISKAS TASTY MIX.png')">i</button>
                </div>

                <div class="card" data-category="Food" data-price="659"><img src="../products/DOG DF/AOZI DOG ADULT.jpg">
                    <h4>Aozi Adult Gold Dry Dog Food 2.5kg</h4>
                    <div class="card-price-container">
                        <p>₱659</p>
                    </div><button class="info-btn"
                        onclick="openInfo('Aozi Adult Gold Dry Dog Food 2.5kg', 'A premium formula that supports overall health and energy in adult dogs. It helps maintain strength and daily activity.', '../products/DOG DF/AOZI DOG ADULT.jpg')">i</button>
                </div>
                <div class="card" data-category="Food" data-price="289"><img src="../products/DOG DF/AOZI DOG PUPPY.png">
                    <h4>Aozi Puppy Organic Lamb Dry Dog Food 2.5kg</h4>
                    <div class="card-price-container">
                        <p>₱289</p>
                    </div><button class="info-btn"
                        onclick="openInfo('Aozi Puppy Organic Lamb Dry Dog Food 2.5kg', 'A lamb-based formula that promotes healthy puppy growth. It supports development and strong immunity.', '../products/DOG DF/AOZI DOG PUPPY.png')">i</button>
                </div>
                <div class="card" data-category="Food" data-price="702"><img src="../products/DOG DF/BEEF PRO ADULT.jpg">
                    <h4>Beef Pro Adult - 50 lb Sack</h4>
                    <div class="card-price-container">
                        <p>₱702</p>
                    </div><button class="info-btn"
                        onclick="openInfo('Beef Pro Adult - 50 lb Sack', 'A bulk option ideal for feeding multiple adult dogs daily. It ensures consistent nutrition at a lower cost.', '../products/DOG DF/BEEF PRO ADULT.jpg')">i</button>
                </div>
                <div class="card" data-category="Food" data-price="323"><img src="../products/DOG DF/BEEF PRO PUPPY.png">
                    <h4>Beef Pro Puppy - 50 lb Sack</h4>
                    <div class="card-price-container">
                        <p>₱323</p>
                    </div><button class="info-btn"
                        onclick="openInfo('Beef Pro Puppy - 50 lb Sack', 'A high-protein puppy food that supports growth and development. It helps build muscles and energy levels.', '../products/DOG DF/BEEF PRO PUPPY.png')">i</button>
                </div>
                <div class="card" data-category="Food" data-price="725"><img src="../products/DOG DF/BEEF TERIYAKI.png">
                    <h4>BEEF TERIYAKI DOG FOOD 8KG</h4>
                    <div class="card-price-container">
                        <p>₱725</p>
                    </div><button class="info-btn"
                        onclick="openInfo('BEEF TERIYAKI DOG FOOD 8KG', 'A flavorful dry food option designed for daily feeding. It provides balanced nutrition for overall health.', '../products/DOG DF/BEEF TERIYAKI.png')">i</button>
                </div>
                <div class="card" data-category="Food" data-price="775"><img src="../products/DOG DF/HOLISTIC ADULT.jpg">
                    <h4>Holistic Recipe Lamb & Rice Adult Dry Dog Food</h4>
                    <div class="card-price-container">
                        <p>₱775</p>
                    </div><button class="info-btn"
                        onclick="openInfo('Holistic Recipe Lamb & Rice Adult Dry Dog Food', 'A gentle formula that supports digestion and overall health. It is suitable for dogs with sensitive stomachs.', '../products/DOG DF/HOLISTIC ADULT.jpg')">i</button>
                </div>
                <div class="card" data-category="Food" data-price="129"><img src="../products/DOG DF/HOLISTIC PUPPY.png">
                    <h4>Holistic Recipe Puppy and Pregnant Lamb Meal and Rice Dry Dog Food 1.5kg</h4>
                    <div class="card-price-container">
                        <p>₱129</p>
                    </div><button class="info-btn"
                        onclick="openInfo('Holistic Recipe Puppy and Pregnant', 'Designed for puppies and pregnant dogs, supporting growth and nutrition. It provides essential nutrients for development.', '../products/DOG DF/HOLISTIC PUPPY.png')">i</button>
                </div>
                <div class="card" data-category="Food" data-price="585"><img src="../products/DOG DF/MORANDO ADULT.png">
                    <h4>Morando Professional Dog Adult Beef 15kg</h4>
                    <div class="card-price-container">
                        <p>₱585</p>
                    </div><button class="info-btn"
                        onclick="openInfo('Morando Professional Dog Adult Beef 15kg', 'A balanced formula that supports adult dog health and energy. It helps maintain strong muscles and vitality.', '../products/DOG DF/MORANDO ADULT.png')">i</button>
                </div>
                <div class="card" data-category="Food" data-price="589"><img src="../products/DOG DF/MORANDO DOG PUPPY.png">
                    <h4>Morando Professional Puppy With Chicken 15kg</h4>
                    <div class="card-price-container">
                        <p>₱589</p>
                    </div><button class="info-btn"
                        onclick="openInfo('Morando Professional Puppy With Chicken 15kg', 'A nutrient-rich puppy food that promotes healthy development. It supports bones, muscles, and immunity.', '../products/DOG DF/MORANDO DOG PUPPY.png')">i</button>
                </div>
                <div class="card" data-category="Food" data-price="776"><img src="../products/DOG DF/NUTRICHUNCKS PUPPY.png">
                    <h4>Nutri Chunks Hi-Protein Lamb Puppy 10kg</h4>
                    <div class="card-price-container">
                        <p>₱776</p>
                    </div><button class="info-btn"
                        onclick="openInfo('Nutri Chunks Hi-Protein Lamb Puppy 10kg', 'A high-protein formula for active and growing puppies. It helps sustain energy and strength.', '../products/DOG DF/NUTRICHUNCKS PUPPY.png')">i</button>
                </div>
                <div class="card" data-category="Food" data-price="323"><img src="../products/DOG DF/NUTRICHUNKS ADULT YELLOW.jpeg">
                    <h4>Nutri Chunks Maintenance Adult Beef 20kg</h4>
                    <div class="card-price-container">
                        <p>₱323</p>
                    </div><button class="info-btn"
                        onclick="openInfo('Nutri Chunks Maintenance Adult Beef 20kg', 'A maintenance formula that supports daily nutrition for adult dogs. It ensures long-term health and stability.', '../products/DOG DF/NUTRICHUNKS ADULT YELLOW.jpeg')">i</button>
                </div>
                <div class="card" data-category="Food" data-price="776"><img src="../products/DOG DF/PEDIGREE ADULT.png">
                    <h4>Pedigree Adult Chicken and Vegetables Dry Dog Food 1.5kg</h4>
                    <div class="card-price-container">
                        <p>₱776</p>
                    </div><button class="info-btn"
                        onclick="openInfo('Pedigree Adult Chicken and Vegetables Dry Dog Food 1.5kg', 'A trusted brand offering complete daily nutrition. It supports overall health and well-being.', '../products/DOG DF/PEDIGREE ADULT.png')">i</button>
                </div>
                <div class="card" data-category="Food" data-price="714"><img src="../products/DOG DF/PEDIGREE MINI.jpg">
                    <h4>Pedigree Adult Mini Grilled Liver Dry Dog Food 2.7kg</h4>
                    <div class="card-price-container">
                        <p>₱714</p>
                    </div><button class="info-btn"
                        onclick="openInfo('Pedigree Adult Mini Grilled Liver Dry Dog Food 2.7kg', 'A flavorful dry food designed for smaller dog breeds. It is easy to chew and digest.', '../products/DOG DF/PEDIGREE MINI.jpg')">i</button>
                </div>
                <div class="card" data-category="Food" data-price="101"><img src="../products/DOG DF/PEDIGREE PUPPY.png">
                    <h4>Pedigree Puppy Beef and Milk Dry Dog Food 2.7kg</h4>
                    <div class="card-price-container">
                        <p>₱101</p>
                    </div><button class="info-btn"
                        onclick="openInfo('Pedigree Puppy Beef and Milk Dry Dog Food 2.7kg', 'Supports bone development and energy in puppies. It provides essential nutrients for growth.', '../products/DOG DF/PEDIGREE PUPPY.png')">i</button>
                </div>
                <div class="card" data-category="Food" data-price="161"><img src="../products/DOG DF/SPECIAL DOG ADULT.png">
                    <h4>Special Dog Adult Lamb & Rice 9kg</h4>
                    <div class="card-price-container">
                        <p>₱161</p>
                    </div><button class="info-btn"
                        onclick="openInfo('Special Dog Adult Lamb & Rice 9kg', 'A balanced formula for adult dogs with sensitive digestion. It helps maintain a healthy gut.', '../products/DOG DF/SPECIAL DOG ADULT.png')">i</button>
                </div>
                <div class="card" data-category="Food" data-price="108"><img src="../products/DOG DF/SPECIAL DOG PUPPY.png">
                    <h4>Special Dog Puppy Lamb & Rice 9kg</h4>
                    <div class="card-price-container">
                        <p>₱108</p>
                    </div><button class="info-btn"
                        onclick="openInfo('Special Dog Puppy Lamb & Rice 9kg', 'Supports healthy growth in puppies. It ensures proper development and nutrition.', '../products/DOG DF/SPECIAL DOG PUPPY.png')">i</button>
                </div>
                <div class="card" data-category="Food" data-price="592"><img src="../products/DOG DF/TOPBREED ADULT.png">
                    <h4>TopBreed Adult Meal 20kg</h4>
                    <div class="card-price-container">
                        <p>₱592</p>
                    </div><button class="info-btn"
                        onclick="openInfo('TopBreed Adult Meal 20kg', 'A cost-effective bulk option for everyday feeding. It is suitable for multiple dogs.', '../products/DOG DF/TOPBREED ADULT.png')">i</button>
                </div>
                <div class="card" data-category="Food" data-price="678"><img src="../products/DOG DF/TOPBREED PUPPY.png">
                    <h4>TopBreed Puppy Meal Dry Dog Food 500g</h4>
                    <div class="card-price-container">
                        <p>₱678</p>
                    </div><button class="info-btn"
                        onclick="openInfo('TopBreed Puppy Meal Dry Dog Food 500g', 'A small pack ideal for puppy feeding. It is convenient and easy to store.', '../products/DOG DF/TOPBREED PUPPY.png')">i</button>
                </div>
                <div class="card" data-category="Food" data-price="483"><img src="../products/DOG DF/V.VALUE MEAL PUPPY.jpg">
                    <h4>Vitality ValueMeal Lamb & Beef Puppy Dry Food</h4>
                    <div class="card-price-container">
                        <p>₱483</p>
                    </div><button class="info-btn"
                        onclick="openInfo('Vitality ValueMeal Lamb & Beef Puppy Dry Food', 'Provides essential nutrients for puppy growth. It supports development and activity.', '../products/DOG DF/V.VALUE MEAL PUPPY.jpg')">i</button>
                </div>
                <div class="card" data-category="Food" data-price="386"><img src="../products/DOG DF/VITALITY ADULT.png">
                    <h4>Vitality ValueMeal Adult for All Breeds Lamb & Beef Food Food</h4>
                    <div class="card-price-container">
                        <p>₱386</p>
                    </div><button class="info-btn"
                        onclick="openInfo('Vitality ValueMeal Adult for All Breeds', 'A balanced diet suitable for adult dogs. It helps maintain overall health.', '../products/DOG DF/VITALITY ADULT.png')">i</button>
                </div>
                <div class="card" data-category="Food" data-price="381"><img src="../products/DOG DF/VITALITY CLASSIC.jpg">
                    <h4>Vitality Classic Lamb & Beef Dog Dry Food</h4>
                    <div class="card-price-container">
                        <p>₱381</p>
                    </div><button class="info-btn"
                        onclick="openInfo('Vitality Classic Lamb & Beef Dog Dry Food', 'A classic formula for everyday feeding. It provides consistent nutrition.', '../products/DOG DF/VITALITY CLASSIC.jpg')">i</button>
                </div>
                <div class="card" data-category="Food" data-price="761"><img src="../products/DOG DF/VITALITY HIGH ENERGY.jpg">
                    <h4>Vitality High Energy Small Breed Dry Dog Food 15kg</h4>
                    <div class="card-price-container">
                        <p>₱761</p>
                    </div><button class="info-btn"
                        onclick="openInfo('Vitality High Energy Small Breed', 'Designed for active small breed dogs needing extra energy. It supports high activity levels.', '../products/DOG DF/VITALITY HIGH ENERGY.jpg')">i</button>
                </div>
                <div class="card" data-category="Food" data-price="761"><img src="../products/DOG DF/WHOOFY.jpg">
                    <h4>Woofy Adult Dog Food 2Okg</h4>
                    <div class="card-price-container">
                        <p>₱900</p>
                    </div><button class="info-btn"
                        onclick="openInfo('Woofy Adult Dog Food 2Okg', 'It offers basic, balanced nutrition featuring a meat mix flavor (bovine, poultry, fish) with a guaranteed analysis of 18% protein and 8% fat, aimed at maintaining healthy skin and coat.', '../products/DOG DF/WHOOFY.jpg')">i</button>
                </div>

                <div class="card" data-category="Food" data-price="640"><img src="../products/DOG WF/AOZI CAN BEEF.png">
                    <h4>Aozi Beef Wet Dog Food 430g</h4>
                    <div class="card-price-container">
                        <p>₱640</p>
                    </div><button class="info-btn"
                        onclick="openInfo('Aozi Beef Wet Dog Food 430g', 'A moist beef meal that improves digestion and hydration. It is easy to eat and suitable for daily feeding.', '../products/DOG WF/AOZI CAN BEEF.png')">i</button>
                </div>
                <div class="card" data-category="Food" data-price="369"><img src="../products/DOG WF/beef&liver.png">
                    <h4>Aozi Beef and Liver Wet Dog Food 430g</h4>
                    <div class="card-price-container">
                        <p>₱369</p>
                    </div><button class="info-btn"
                        onclick="openInfo('Aozi Beef and Liver Wet Dog Food 430g', 'A rich combination of beef and liver for added nutrition. It supports energy and overall health.', '../products/DOG WF/beef&liver.png')">i</button>
                </div>
                <div class="card" data-category="Food" data-price="253"><img src="../products/DOG WF/CHEWCHUNX 5-15KG.jpg">
                    <h4>Pedigree Dentastix Chewy Chunx Mini Dog Treats 5-15kg</h4>
                    <div class="card-price-container">
                        <p>₱253</p>
                    </div><button class="info-btn"
                        onclick="openInfo('Pedigree Dentastix Chewy Chunx Mini', 'Dental treats that help reduce plaque and freshen breath. They promote better oral hygiene.', '../products/DOG WF/CHEWCHUNX 5-15KG.jpg')">i</button>
                </div>
                <div class="card" data-category="Food" data-price="172"><img src="../products/DOG WF/CHEWCHUNX 15+ KG.jpg">
                    <h4>Pedigree DentaStix Chewy Chunks Maxi Smoky Chicken 15kg</h4>
                    <div class="card-price-container">
                        <p>₱172</p>
                    </div><button class="info-btn"
                        onclick="openInfo('Pedigree DentaStix Chewy Chunks Maxi', 'Designed for larger dogs to support oral health. It helps maintain strong teeth and gums.', '../products/DOG WF/CHEWCHUNX 15+ KG.jpg')">i</button>
                </div>
                <div class="card" data-category="Food" data-price="969"><img src="../products/DOG WF/DENTASTIX LARGE BREED 3PCS.jpg">
                    <h4>Pedigree DentaStix Large (3 Sticks)</h4>
                    <div class="card-price-container">
                        <p>₱969</p>
                    </div><button class="info-btn"
                        onclick="openInfo('Pedigree DentaStix Large (3 Sticks)', 'Helps maintain clean teeth and healthy gums. It is ideal for daily dental care.', '../products/DOG WF/DENTASTIX LARGE BREED 3PCS.jpg')">i</button>
                </div>
                <div class="card" data-category="Food" data-price="138"><img src="../products/DOG WF/DENTASTIX LARGE BREED 7PCS.jpg">
                    <h4>Pedigree Dentastix Large Breed Dog Chews 7PCS</h4>
                    <div class="card-price-container">
                        <p>₱138</p>
                    </div><button class="info-btn"
                        onclick="openInfo('Pedigree Dentastix Large Breed 7PCS', 'Specially designed for large breed dogs’ dental care. It supports strong teeth and oral hygiene.', '../products/DOG WF/DENTASTIX LARGE BREED 7PCS.jpg')">i</button>
                </div>
                <div class="card" data-category="Food" data-price="411"><img src="../products/DOG WF/DENTASTIX MEDIUM BREED 4PCS.jpg">
                    <h4>Pedigree Dentastix Medium Breed Dog Chews 5PCS</h4>
                    <div class="card-price-container">
                        <p>₱411</p>
                    </div><button class="info-btn"
                        onclick="openInfo('Pedigree Dentastix Medium Breed 4PCS', 'Supports oral hygiene for medium-sized dogs. It helps reduce tartar buildup.', '../products/DOG WF/DENTASTIX MEDIUM BREED 4PCS.jpg')">i</button>
                </div>
                <div class="card" data-category="Food" data-price="944"><img src="../products/DOG WF/DENTASTIX MONO.png">
                    <h4>Pedigree Dentastix Mono 7 Sticks</h4>
                    <div class="card-price-container">
                        <p>₱944</p>
                    </div><button class="info-btn"
                        onclick="openInfo('Pedigree Dentastix Mono 3 Sticks', 'Simple dental treat for everyday use. It keeps teeth clean and breath fresh.', '../products/DOG WF/DENTASTIX MONO.png')">i</button>
                </div>
                <div class="card" data-category="Food" data-price="667"><img src="../products/DOG WF/DENTASTIX PUPPY.png">
                    <h4>Pedigree DentaStix Puppy (3-12 months) (7 Sticks)</h4>
                    <div class="card-price-container">
                        <p>₱667</p>
                    </div><button class="info-btn"
                        onclick="openInfo('Pedigree DentaStix Puppy (7 Sticks)', 'Gentle dental care designed for puppies. It supports early oral health.', '../products/DOG WF/DENTASTIX PUPPY.png')">i</button>
                </div>
                <div class="card" data-category="Food" data-price="685"><img src="../products/DOG WF/DENTASTIX TOY DOG.jpg">
                    <h4>Pedigree DentaStix Toy (up to 5kg) 60g (7 sticks)</h4>
                    <div class="card-price-container">
                        <p>₱685</p>
                    </div><button class="info-btn"
                        onclick="openInfo('Pedigree DentaStix Toy (7 sticks)', 'Suitable for small breeds to maintain dental health. It helps prevent plaque buildup.', '../products/DOG WF/DENTASTIX TOY DOG.jpg')">i</button>
                </div>
                <div class="card" data-category="Food" data-price="265"><img src="../products/DOG WF/DOGGIE BISCUITS.png">
                    <h4>Pet Plus Doggie Biscuits Bone Shape Dog Treats 250g</h4>
                    <div class="card-price-container">
                        <p>₱265</p>
                    </div><button class="info-btn"
                        onclick="openInfo('Pet Plus Doggie Biscuits', 'Crunchy bone-shaped treats for training and rewards. They are great for positive reinforcement.', '../products/DOG WF/DOGGIE BISCUITS.png')">i</button>
                </div>
                <div class="card" data-category="Food" data-price="208"><img src="../products/DOG WF/MILKBONE.png">
                    <h4>Milk-Bone Original Dog Biscuits Small</h4>
                    <div class="card-price-container">
                        <p>₱208</p>
                    </div><button class="info-btn"
                        onclick="openInfo('Milk-Bone Original Dog Biscuits Small', 'Classic crunchy treats for everyday snacking. They help maintain dental health.', '../products/DOG WF/MILKBONE.png')">i</button>
                </div>
                <div class="card" data-category="Food" data-price="915"><img src="../products/DOG WF/MORANDO CAN ADULT.png">
                    <h4>Morando Professional Pate Lamb Adult Dog Food Can 400g</h4>
                    <div class="card-price-container">
                        <p>₱915</p>
                    </div><button class="info-btn"
                        onclick="openInfo('Morando Professional Pate Lamb Adult', 'A soft pate-style wet food for adult dogs. It is easy to chew and digest.', '../products/DOG WF/MORANDO CAN ADULT.png')">i</button>
                </div>
                <div class="card" data-category="Food" data-price="742"><img src="../products/DOG WF/PEDIGREE CHEWBONE LARGE.jpg">
                    <h4>Good Chew Beef Large 138g</h4>
                    <div class="card-price-container">
                        <p>₱742</p>
                    </div><button class="info-btn"
                        onclick="openInfo('Good Chew Beef Large 138g', 'A long-lasting chew that promotes dental health. It helps reduce boredom and stress.', '../products/DOG WF/PEDIGREE CHEWBONE LARGE.jpg')">i</button>
                </div>
                <div class="card" data-category="Food" data-price="440"><img src="../products/DOG WF/PEDIGREE CHEWBONE SMALL.jpg">
                    <h4>Pedigree Adult Good Chew Beef Small Breed Dog Treats 53g</h4>
                    <div class="card-price-container">
                        <p>₱440</p>
                    </div><button class="info-btn"
                        onclick="openInfo('Pedigree Adult Good Chew Beef Small', 'A chew treat designed for small dogs. It is easy to chew and enjoyable.', '../products/DOG WF/PEDIGREE CHEWBONE SMALL.jpg')">i</button>
                </div>
                <div class="card" data-category="Food" data-price="553"><img src="../products/DOG WF/PEDIGREE CHEWCHUNK SMALL.png">
                    <h4>Pedigree Chewchunk Small</h4>
                    <div class="card-price-container">
                        <p>₱553</p>
                    </div><button class="info-btn"
                        onclick="openInfo('Pedigree Chewchunk Small', 'Bite-sized chew treats for quick rewards. They are perfect for training sessions.', '../products/DOG WF/PEDIGREE CHEWCHUNK SMALL.png')">i</button>
                </div>
                <div class="card" data-category="Food" data-price="817"><img src="../products/DOG WF/PEDIGREE DOG CAN 400G.jpg">
                    <h4>Pedigree Adult Beef Wet Dog Food 400g</h4>
                    <div class="card-price-container">
                        <p>₱817</p>
                    </div><button class="info-btn"
                        onclick="openInfo('Pedigree Adult Beef Wet Dog Food 400g', 'A soft and flavorful wet meal for adult dogs. It provides balanced nutrition.', '../products/DOG WF/PEDIGREE DOG CAN 400G.jpg')">i</button>
                </div>
                <div class="card" data-category="Food" data-price="668"><img src="../products/DOG WF/PEDIGREE MEAT RODEO.jpg">
                    <h4>Pedigree Rodeo Treats 90g</h4>
                    <div class="card-price-container">
                        <p>₱668</p>
                    </div><button class="info-btn"
                        onclick="openInfo('Pedigree Rodeo Treats 90g', 'Twisted chew treats for fun snacking. They keep dogs entertained.', '../products/DOG WF/PEDIGREE MEAT RODEO.jpg')">i</button>
                </div>
                <div class="card" data-category="Food" data-price="872"><img src="../products/DOG WF/PEDIGREE MEET JERKY.png">
                    <h4>Pedigree D Meat Jerky Smky Beef 60G</h4>
                    <div class="card-price-container">
                        <p>₱872</p>
                    </div><button class="info-btn"
                        onclick="openInfo('Pedigree D Meat Jerky Smoky Beef', 'A chewy jerky-style treat with smoky flavor. It is rich in taste and satisfying.', '../products/DOG WF/PEDIGREE MEET JERKY.png')">i</button>
                </div>
                <div class="card" data-category="Food" data-price="710"><img src="../products/DOG WF/PEDIGREE POUCH ADULT.png">
                    <h4>Pedigree Adult Beef Chunks in Gravy Wet Dog Food 130g</h4>
                    <div class="card-price-container">
                        <p>₱710</p>
                    </div><button class="info-btn"
                        onclick="openInfo('Pedigree Adult Beef Chunks in Gravy', 'A gravy-based wet food for added taste. It improves appetite and enjoyment.', '../products/DOG WF/PEDIGREE POUCH ADULT.png')">i</button>
                </div>
                <div class="card" data-category="Food" data-price="643"><img src="../products/DOG WF/PEDIGREE POUCH PUPPY.png">
                    <h4>Pedigree Puppy Chicken Chunks in Gravy Wet Dog Food 130g</h4>
                    <div class="card-price-container">
                        <p>₱643</p>
                    </div><button class="info-btn"
                        onclick="openInfo('Pedigree Puppy Chicken Chunks in Gravy', 'A soft and nutritious meal for puppies. It supports growth and development.', '../products/DOG WF/PEDIGREE POUCH PUPPY.png')">i</button>
                </div>
                <div class="card" data-category="Food" data-price="386"><img src="../products/DOG WF/PEDIGREE TASTYBITES.jpg">
                    <h4>Pedigree Tasty Bites Chewy Cubes Beef Dog Treats 50g</h4>
                    <div class="card-price-container">
                        <p>₱386</p>
                    </div><button class="info-btn"
                        onclick="openInfo('Pedigree Tasty Bites Chewy Cubes Beef', 'Small chewy treats for training and rewards. They are easy to carry and use.', '../products/DOG WF/PEDIGREE TASTYBITES.jpg')">i</button>
                </div>
                <div class="card" data-category="Food" data-price="388"><img src="../products/DOG WF/SPECIAL DOG CAN 400G.jpg">
                    <h4>Special Dog Can Adult & Puppy Dog Wet Food Monge 400g</h4>
                    <div class="card-price-container">
                        <p>₱388</p>
                    </div><button class="info-btn"
                        onclick="openInfo('Special Dog Can Adult & Puppy Wet', 'A premium canned dog food for daily nutrition. It provides balanced and complete meals.', '../products/DOG WF/SPECIAL DOG CAN 400G.jpg')">i</button>
                </div>
                <div class="card" data-category="Food" data-price="184"><img src="../products/DOG WF/ZERT PREMIUM.png">
                    <h4>Zert's Premium Desserts for Dogs 88g</h4>
                    <div class="card-price-container">
                        <p>₱184</p>
                    </div><button class="info-btn"
                        onclick="openInfo('Zert Premium Desserts for Dogs 88g', 'A unique dessert-style treat for occasional indulgence. It adds variety and enjoyment.', '../products/DOG WF/ZERT PREMIUM.png')">i</button>
                </div>

                <div class="card" data-category="Bowls" data-price="1200"><img src="../products/FWB/Pet Automatic Food Dispenser (White) with Anti-Slip Rubber for Cats and Dogs.png">
                    <h4>Automatic Dog Feeder</h4>
                    <p>₱1,200</p><button class="info-btn"
                        onclick="openInfo('Automatic Dog Feeder', 'The automatic dog feeder offers a convenient way to feed pets.', '../products/FWB/Pet Automatic Food Dispenser (White) with Anti-Slip Rubber for Cats and Dogs.png')">i</button>
                </div>
                <div class="card" data-category="Bowls" data-price="1500"><img src="../products/FWB/Doggo Dog Food Dispenser (Blue) Pet Feeder.png">
                    <h4>Doggo Dog Food Dispenser (Blue)</h4>
                    <p>₱1,500</p><button class="info-btn"
                        onclick="openInfo('Doggo Dog Food Dispenser (Blue)', 'Self-replenishing pet feeder cube automatically refills food.', '../products/FWB/Doggo Dog Food Dispenser (Blue) Pet Feeder.png')">i</button>
                </div>
                <div class="card" data-category="Bowls" data-price="1800"><img src="../products/FWB/Doggo Cube Food Dispenser Station, Self Replenish Pet Feeder (Peach).png">
                    <h4>Doggo Cube Food Dispenser (Peach)</h4>
                    <p>₱1,800</p><button class="info-btn"
                        onclick="openInfo('Doggo Cube Food Dispenser (Peach)', 'Gravity-based system that continuously dispenses food.', '../products/FWB/Doggo Cube Food Dispenser Station, Self Replenish Pet Feeder (Peach).png')">i</button>
                </div>
                <div class="card" data-category="Bowls" data-price="450"><img src="../products/FWB/Kennel Pro Pet Water Fountain.png">
                    <h4>Kennel Pro Pet Water Fountain</h4>
                    <p>₱450</p><button class="info-btn"
                        onclick="openInfo('Kennel Pro Pet Water Fountain', 'Continuous flow water fountain for pets provides fresh water.', '../products/FWB/Kennel Pro Pet Water Fountain.png')">i</button>
                </div>
                <div class="card" data-category="Bowls" data-price="700"><img src="../products/FWB/Pet Food Bowl with Removable Metal Bowl Anti Slip for Cats and Dogs.png">
                    <h4>Pet Food Bowl with Metal Bowl Anti Slip</h4>
                    <p>₱700</p><button class="info-btn"
                        onclick="openInfo('Pet Food Bowl with Metal Bowl Anti Slip', 'Removable metal bowl with an anti-slip base.', '../products/FWB/Pet Food Bowl with Removable Metal Bowl Anti Slip for Cats and Dogs.png')">i</button>
                </div>
                <div class="card" data-category="Bowls" data-price="1350"><img src="../products/FWB/Doggo Quad 2-in-1 Bowl.png">
                    <h4>Doggo Quad 2-in-1 Bowl</h4>
                    <p>₱1,350</p><button class="info-btn"
                        onclick="openInfo('Doggo Quad 2-in-1 Bowl', 'Dual bowl for food and water in one convenient setup.', '../products/FWB/Doggo Quad 2-in-1 Bowl.png')">i</button>
                </div>
                <div class="card" data-category="Bowls" data-price="350"><img src="../products/FWB/Pet Portable Drinking Cup Bottle Water Dispenser for Dogs Foldable CWSJ2556 (Pink).png">
                    <h4>Pet Automatic Food Dispenser (Pink)</h4>
                    <p>₱350</p><button class="info-btn"
                        onclick="openInfo('Pet Automatic Food Dispenser (White)', 'Anti-slip automatic feeder provides steady feeding.', '../products/FWB/Pet Portable Drinking Cup Bottle Water Dispenser for Dogs Foldable CWSJ2556 (Pink).png')">i</button>
                </div>
                <div class="card" data-category="Bowls" data-price="400"><img src="../products/FWB/Slow Down Bowl.png">
                    <h4>Slow Down Bowl</h4>
                    <p>₱400</p><button class="info-btn"
                        onclick="openInfo('Slow Down Bowl', 'Designed to slow fast eaters to prevent choking.', '../products/FWB/Slow Down Bowl.png')">i</button>
                </div>

                <div class="card" data-category="Grooming" data-price="250"><img src="../products/GT/Lucky Dog Pet Nail Trimmer with Nail File Orange.png">
                    <h4>Lucky Dog Pet Nail Trimmer with File</h4>
                    <p>₱250</p><button class="info-btn"
                        onclick="openInfo('Lucky Dog Pet Nail Trimmer', 'Nail trimmer with built-in file for safe and precise grooming.', '../products/GT/Lucky Dog Pet Nail Trimmer with Nail File Orange.png')">i</button>
                </div>
                <div class="card" data-category="Grooming" data-price="200"><img src="../products/GT/Bamboo Soft Bristle Brush.png">
                    <h4>Bamboo Soft Bristle Brush</h4>
                    <p>₱200</p><button class="info-btn"
                        onclick="openInfo('Bamboo Soft Bristle Brush', 'Soft bristle brush offers gentle daily brushing.', '../products/GT/Bamboo Soft Bristle Brush.png')">i</button>
                </div>
                <div class="card" data-category="Grooming" data-price="499"><img src="../products/GT/The Fur Life S.O.S Clean Surface Dog Spray 500ml.png">
                    <h4>The Fur Life S.O.S Clean Spray 500ml</h4>
                    <p>₱499</p><button class="info-btn"
                        onclick="openInfo('The Fur Life S.O.S Clean Surface Dog Spray', 'Dual-sided bamboo brush combines grooming and detangling.', '../products/GT/The Fur Life S.O.S Clean Surface Dog Spray 500ml.png')">i</button>
                </div>
                <div class="card" data-category="Grooming" data-price="180"><img src="../products/GT/Lucky Dog Dual Side Bamboo Pet Brush.png">
                    <h4>Lucky Dog Dual Side Bamboo Pet Brush</h4>
                    <p>₱180</p><button class="info-btn"
                        onclick="openInfo('Lucky Dog Dual Side Bamboo Pet Brush', 'Efficiently keeps fur healthy and knot-free.', '../products/GT/Lucky Dog Dual Side Bamboo Pet Brush.png')">i</button>
                </div>
                <div class="card" data-category="Grooming" data-price="350"><img src="../products/GT/PETEXP10289695SteelDogComb1_800x.png">
                    <h4>Lucky Dog Double-Sided Steel Pet Comb</h4>
                    <p>₱350</p><button class="info-btn"
                        onclick="openInfo('Lucky Dog Double-Sided Steel Pet Comb', 'Stainless steel comb ideal for tackling mats and knots.', '../products/GT/PETEXP10289695SteelDogComb1_800x.png')">i</button>
                </div>
                <div class="card" data-category="Grooming" data-price="150"><img src="../products/GT/Purry Waterless Dog Shampoo 200ml.png">
                    <h4>Purry Waterless Dog Shampoo 200ml</h4>
                    <p>₱150</p><button class="info-btn"
                        onclick="openInfo('Purry Waterless Dog Shampoo 200ml', 'Waterless dog shampoo provides quick clean-up without rinsing.', '../products/GT/Purry Waterless Dog Shampoo 200ml.png')">i</button>
                </div>
                <div class="card" data-category="Grooming" data-price="220"><img src="../products/GT/Pampered Pooch Anti Bacterial Dog Soap 70g.png">
                    <h4>Pampered Pooch Anti Bacterial Dog Soap 70g</h4>
                    <p>₱220</p><button class="info-btn"
                        onclick="openInfo('Pampered Pooch Anti Bacterial Dog Soap 70g', 'Anti-bacterial soap helps maintain a healthy, clean coat.', '../products/GT/Pampered Pooch Anti Bacterial Dog Soap 70g.png')">i</button>
                </div>
                <div class="card" data-category="Grooming" data-price="320"><img src="../products/GT/Gentle Paws Watermelon Splash Moisturizer Pet Balm 25g.png">
                    <h4>Gentle Paws Watermelon Moisturizer Balm 25g</h4>
                    <p>₱320</p><button class="info-btn"
                        onclick="openInfo('Gentle Paws Watermelon Balm', 'Paw balm formulated to protect and soothe paws.', '../products/GT/Gentle Paws Watermelon Splash Moisturizer Pet Balm 25g.png')">i</button>
                </div>

                <div class="card" data-category="Toys" data-price="180"><img src="../products/PETTOYA/Extra Strong Dog Toy Frisbee with 2 Holes 20cm.png">
                    <h4>Extra Strong Dog Toy Frisbee 20cm</h4>
                    <p>₱180</p><button class="info-btn"
                        onclick="openInfo('Extra Strong Dog Toy Frisbee', 'Durable frisbee perfect for active play sessions.', '../products/PETTOYA/Extra Strong Dog Toy Frisbee with 2 Holes 20cm.png')">i</button>
                </div>
                <div class="card" data-category="Toys" data-price="220"><img src="../products/PETTOYA/Extra Strong Dog Toy Triangular Ball Shape 14x14cm.png">
                    <h4>Extra Strong Dog Toy Triangular Ball</h4>
                    <p>₱220</p><button class="info-btn"
                        onclick="openInfo('Extra Strong Dog Toy Triangular Ball', 'Tough chew ball satisfies instincts and promotes dental health.', '../products/PETTOYA/Extra Strong Dog Toy Triangular Ball Shape 14x14cm.png')">i</button>
                </div>
                <div class="card" data-category="Toys" data-price="300"><img src="../products/PETTOYA/Interactive Rubber IQ Dog Toy Large 14x6cm.png">
                    <h4>Interactive Rubber IQ Dog Toy Large</h4>
                    <p>₱300</p><button class="info-btn"
                        onclick="openInfo('Interactive Rubber IQ Dog Toy', 'Puzzle toy stimulates pets’ minds and energy.', '../products/PETTOYA/Interactive Rubber IQ Dog Toy Large 14x6cm.png')">i</button>
                </div>
                <div class="card" data-category="Toys" data-price="350"><img src="../products/PETTOYA/Pet T-Shirt w_Sleeve with Stripes on the side for Dog and Cat.png">
                    <h4>Pet T-Shirt with Stripes Side</h4>
                    <p>₱350</p><button class="info-btn"
                        onclick="openInfo('Pet T-Shirt Side Stripes', 'Stylish pet shirt, lightweight and comfortable for everyday wear.', '../products/PETTOYA/Pet T-Shirt w_Sleeve with Stripes on the side for Dog and Cat.png')">i</button>
                </div>
                <div class="card" data-category="Toys" data-price="500"><img src="../products/PETTOYA/Mickey and Minnie Front Pet Costume for Dog and Cat.png">
                    <h4>Mickey and Minnie Front Pet Costume</h4>
                    <p>₱500</p><button class="info-btn"
                        onclick="openInfo('Mickey and Minnie Front Pet Costume', 'Themed costume lets pets enjoy fun occasions in style.', '../products/PETTOYA/Mickey and Minnie Front Pet Costume for Dog and Cat.png')">i</button>
                </div>
                <div class="card" data-category="Toys" data-price="300"><img src="../products/PETTOYA/Pet Shirt June Collections.png">
                    <h4>Pet Shirt June Collections</h4>
                    <p>₱300</p><button class="info-btn"
                        onclick="openInfo('Pet Shirt June Collections', 'Lightweight everyday shirt designed for comfort.', '../products/PETTOYA/Pet Shirt June Collections.png')">i</button>
                </div>
                <div class="card" data-category="Toys" data-price="250"><img src="../products/PETTOYA/Dog Toy Toss Tugger Football Small 28cm(1).png">
                    <h4>Dog Toy Toss Tugger Football Small</h4>
                    <p>₱250</p><button class="info-btn"
                        onclick="openInfo('Dog Toy Toss Tugger Football', 'Fun tug toy for small dogs providing safe exercise.', '../products/PETTOYA/Dog Toy Toss Tugger Football Small 28cm(1).png')">i</button>
                </div>
                <div class="card" data-category="Toys" data-price="400"><img src="../products/PETTOYA/Dog Toy Play n Chew 48x7cm.png">
                    <h4>Dog Toy Play n Chew 48x7cm</h4>
                    <p>₱400</p><button class="info-btn"
                        onclick="openInfo('Dog Toy Play n Chew', 'Chew-resistant play toy built for heavy chewers.', '../products/PETTOYA/Dog Toy Play n Chew 48x7cm.png')">i</button>
                </div>
                <div class="card" data-category="Toys" data-price="350"><img src="../products/PETTOYA/Dog Toy Vinyl dumbbell bone 16x6x6cm.png">
                    <h4>Dog Toy Vinyl dumbbell bone</h4>
                    <p>₱350</p><button class="info-btn"
                        onclick="openInfo('Dog Toy Vinyl dumbbell bone', 'Durable vinyl dumbbell for fetching and chewing.', '../products/PETTOYA/Dog Toy Vinyl dumbbell bone 16x6x6cm.png')">i</button>
                </div>
                <div class="card" data-category="Toys" data-price="600"><img src="../products/PETTOYA/Doggy Boots 2 Pieces XL.png">
                    <h4>Doggy Boots 2 Pieces XL</h4>
                    <p>₱600</p><button class="info-btn"
                        onclick="openInfo('Doggy Boots 2 Pieces XL', 'Protective boots ideal for outdoor walks and rough terrain.', '../products/PETTOYA/Doggy Boots 2 Pieces XL.png')">i</button>
                </div>

                <div class="card" data-category="Leash" data-price="750"><img src="../products/LEASHES/PETIO W56447 Reel Lead Road L Red Dog Leash.png">
                    <h4>PETIO W56447 Reel Lead Road L Red</h4>
                    <p>₱750</p><button class="info-btn"
                        onclick="openInfo('PETIO Reel Lead Dog Leash', 'Durable red reel leash for medium to large dogs.', '../products/LEASHES/PETIO W56447 Reel Lead Road L Red Dog Leash.png')">i</button>
                </div>
                <div class="card" data-category="Leash" data-price="350"><img src="../products/LEASHES/JX Elizabeth Colored Collar Small.png">
                    <h4>JX Elizabeth Colored Collar Small</h4>
                    <p>₱350</p><button class="info-btn"
                        onclick="openInfo('JX Elizabeth Colored Collar', 'Colorful collar for small dogs, secure and comfortable.', '../products/LEASHES/JX Elizabeth Colored Collar Small.png')">i</button>
                </div>
                <div class="card" data-category="Leash" data-price="400"><img src="../products/LEASHES/DGZ High Quality Paper Elizabeth Collar 2 Pieces for Dog and Cat.png">
                    <h4>DGZ High Quality Paper Elizabeth Collar</h4>
                    <p>₱400</p><button class="info-btn"
                        onclick="openInfo('DGZ Paper Elizabeth Collar', 'High-quality paper collar pack suitable for both dogs and cats.', '../products/LEASHES/DGZ High Quality Paper Elizabeth Collar 2 Pieces for Dog and Cat.png')">i</button>
                </div>
                <div class="card" data-category="Leash" data-price="500"><img src="../products/LEASHES/Approved Ribbon 2-in-1 Cat Harness and Leash 1.0.png">
                    <h4>Approved Ribbon 2-in-1 Cat Harness</h4>
                    <p>₱500</p><button class="info-btn"
                        onclick="openInfo('Approved Ribbon Cat Harness', 'Ribbon harness with leash for cats. Safety and style.', '../products/LEASHES/Approved Ribbon 2-in-1 Cat Harness and Leash 1.0.png')">i</button>
                </div>
                <div class="card" data-category="Leash" data-price="550"><img src="../products/LEASHES/Approved Plush Star 2-in-1 Dog Harness and Leash 1.0.png">
                    <h4>Approved Plush Star 2-in-1 Harness</h4>
                    <p>₱550</p><button class="info-btn"
                        onclick="openInfo('Approved Plush Star Harness', 'Plush 2-in-1 harness and leash for dogs. Soft material.', '../products/LEASHES/Approved Plush Star 2-in-1 Dog Harness and Leash 1.0.png')">i</button>
                </div>
                <div class="card" data-category="Leash" data-price="600"><img src="../products/LEASHES/Zee.Dog Honey Dog Leash Small.png">
                    <h4>Zee.Dog Honey Dog Leash Small</h4>
                    <p>₱600</p><button class="info-btn"
                        onclick="openInfo('Zee.Dog Honey Dog Leash', 'Compact leash with honey design, ideal for small dogs.', '../products/LEASHES/Zee.Dog Honey Dog Leash Small.png')">i</button>
                </div>
                <div class="card" data-category="Leash" data-price="650"><img src="../products/LEASHES/Bark and Spark Frozen Olaf Dog Leash Medium Blue.png">
                    <h4>Bark & Spark Frozen Olaf Leash Medium</h4>
                    <p>₱650</p><button class="info-btn"
                        onclick="openInfo('Bark and Spark Frozen Olaf Leash', 'Frozen Olaf themed leash adds a fun touch.', '../products/LEASHES/Bark and Spark Frozen Olaf Dog Leash Medium Blue.png')">i</button>
                </div>
                <div class="card" data-category="Leash" data-price="800"><img src="../products/LEASHES/EzyDog Double Up Dog Collar Large Denim.png">
                    <h4>EzyDog Double Up Dog Collar Large</h4>
                    <p>₱800</p><button class="info-btn"
                        onclick="openInfo('EzyDog Double Up Dog Collar', 'Denim double-up collar for large dogs. Sturdy and fashionable.', '../products/LEASHES/EzyDog Double Up Dog Collar Large Denim.png')">i</button>
                </div>
                <div class="card" data-category="Leash" data-price="300"><img src="../products/LEASHES/Checkered Ribbon Pet Collar 1.5.png">
                    <h4>Checkered Ribbon Pet Collar 1.5</h4>
                    <p>₱300</p><button class="info-btn"
                        onclick="openInfo('Checkered Ribbon Pet Collar', 'Adjustable checkered ribbon collar. Classic and practical.', '../products/LEASHES/Checkered Ribbon Pet Collar 1.5.png')">i</button>
                </div>
                <div class="card" data-category="Leash" data-price="450"><img src="../products/LEASHES/Bark and Spark Team Mickey Dog Collar Medium Blue.png">
                    <h4>Bark & Spark Team Mickey Collar Medium</h4>
                    <p>₱450</p><button class="info-btn"
                        onclick="openInfo('Bark and Spark Team Mickey Collar', 'Team Mickey collar combines fandom and functionality.', '../products/LEASHES/Bark and Spark Team Mickey Dog Collar Medium Blue.png')">i</button>
                </div>
                <div class="card" data-category="Leash" data-price="700"><img src="../products/LEASHES/M-Pets Hiking Dog Collar Extra Large Black Orange.png">
                    <h4>M-Pets Hiking Dog Collar XL</h4>
                    <p>₱700</p><button class="info-btn"
                        onclick="openInfo('M-Pets Hiking Dog Collar Extra Large', 'Hiking collar for adventurous pets. Durable and protective.', '../products/LEASHES/M-Pets Hiking Dog Collar Extra Large Black Orange.png')">i</button>
                </div>

                <div class="card" data-category="Bedding" data-price="1200"><img src="../products/PETBH/Mewoo - Cotton Candy Cloud Pet Bed.png">
                    <h4>Mewoo - Cotton Candy Cloud Pet Bed</h4>
                    <p>₱1,200</p><button class="info-btn"
                        onclick="openInfo('Mewoo Cloud Bed', 'Soft cloud-like bed provides a cozy place to sleep.', '../products/PETBH/Mewoo - Cotton Candy Cloud Pet Bed.png')">i</button>
                </div>
                <div class="card" data-category="Bedding" data-price="1500"><img src="../products/PETBH/Pet Bed Soft and Comfortable Sleeping Bed XL (Assorted Colors and Designs) for Cats and Dogs.png">
                    <h4>Pet Bed Soft Sleeping Bed XL</h4>
                    <p>₱1,500</p><button class="info-btn"
                        onclick="openInfo('Pet Bed XL Assorted', 'Spacious bed suitable for larger pets. Supports relaxation.', '../products/PETBH/Pet Bed Soft and Comfortable Sleeping Bed XL (Assorted Colors and Designs) for Cats and Dogs.png')">i</button>
                </div>
                <div class="card" data-category="Bedding" data-price="950"><img src="../products/PETBH/PawTalk Flat with Bolster Pet Bed Blue.png">
                    <h4>PawTalk Flat with Bolster Blue</h4>
                    <p>₱950</p><button class="info-btn"
                        onclick="openInfo('PawTalk Flat Bolster Blue', 'Flat bed with bolster adds extra support for comfort.', '../products/PETBH/PawTalk Flat with Bolster Pet Bed Blue.png')">i</button>
                </div>
                <div class="card" data-category="Bedding" data-price="1100"><img src="../products/PETBH/PawTalk Barrel Nest Cushion Pet Bed Gray.png">
                    <h4>PawTalk Barrel Nest Gray</h4>
                    <p>₱1,100</p><button class="info-btn"
                        onclick="openInfo('PawTalk Barrel Nest Gray', 'Barrel-shaped nest bed perfect for cats and small dogs.', '../products/PETBH/PawTalk Barrel Nest Cushion Pet Bed Gray.png')">i</button>
                </div>
                <div class="card" data-category="Bedding" data-price="950"><img src="../products/PETBH/PawTalk Flat with Bolster Pet Bed Gray.png">
                    <h4>PawTalk Flat with Bolster Gray</h4>
                    <p>₱950</p><button class="info-btn"
                        onclick="openInfo('PawTalk Flat Bolster Gray', 'Ideal for pets to relax and feel supported.', '../products/PETBH/PawTalk Flat with Bolster Pet Bed Gray.png')">i</button>
                </div>
                <div class="card" data-category="Bedding" data-price="1050"><img src="../products/PETBH/PawTalk Corduroy Pet Bed Brown.png">
                    <h4>PawTalk Corduroy Bed Brown</h4>
                    <p>₱1,050</p><button class="info-btn"
                        onclick="openInfo('PawTalk Corduroy Pet Bed Brown', 'Durable corduroy bed that combines comfort with long-lasting material.', '../products/PETBH/PawTalk Corduroy Pet Bed Brown.png')">i</button>
                </div>
                <div class="card" data-category="Bedding" data-price="850"><img src="../products/PETBH/Cat Bed Removable Washable Cat House Warm Comfortable Pet Dog Bed Pet Nest.png">
                    <h4>Cat Bed Washable Pet House</h4>
                    <p>₱850</p><button class="info-btn"
                        onclick="openInfo('Cat Bed Washable', 'Washable cat bed provides convenience and comfort.', '../products/PETBH/Cat Bed Removable Washable Cat House Warm Comfortable Pet Dog Bed Pet Nest.png')">i</button>
                </div>
                <div class="card" data-category="Bedding" data-price="900"><img src="../products/PETBH/Cat Tent Cat Bed Pet Tent Dog Four Seasons Universal Kennel Cat Tents Kennel Dog Bed.png">
                    <h4>Cat Tent Pet Bed</h4>
                    <p>₱900</p><button class="info-btn"
                        onclick="openInfo('Cat Tent Pet Bed', 'Universal pet tent suitable for all seasons.', '../products/PETBH/Cat Tent Cat Bed Pet Tent Dog Four Seasons Universal Kennel Cat Tents Kennel Dog Bed.png')">i</button>
                </div>
                <div class="card" data-category="Bedding" data-price="1300"><img src="../products/PETBH/Mewoo - Mellow Yellow Lounge Bed.png">
                    <h4>Mewoo - Mellow Yellow Lounge Bed</h4>
                    <p>₱1,300</p><button class="info-btn"
                        onclick="openInfo('Mewoo Mellow Yellow Lounge', 'Lounge bed with mellow yellow soft cushioning.', '../products/PETBH/Mewoo - Mellow Yellow Lounge Bed.png')">i</button>
                </div>
                <div class="card" data-category="Bedding" data-price="1350"><img src="../products/PETBH/Mewoo - Sky Cloud Bed.png">
                    <h4>Mewoo - Sky Cloud Bed</h4>
                    <p>₱1,350</p><button class="info-btn"
                        onclick="openInfo('Mewoo Sky Cloud Bed', 'Soft cloud bed delivers ultimate comfort for pets.', '../products/PETBH/Mewoo - Sky Cloud Bed.png')">i</button>
                </div>
                <div class="card" data-category="Bedding" data-price="1400"><img src="../products/PETBH/Mewoo - Playful Paws Pet Cooling Activity Mat.png">
                    <h4>Mewoo Cooling Activity Mat</h4>
                    <p>₱1,400</p><button class="info-btn"
                        onclick="openInfo('Mewoo Cooling Mat', 'Cooling activity mat helps pets stay comfortable in hot weather.', '../products/PETBH/Mewoo - Playful Paws Pet Cooling Activity Mat.png')">i</button>
                </div>
                <div class="card" data-category="Bedding" data-price="1250"><img src="../products/PETBH/Mewoo - Playful Paws Pet Activity Cushion.png">
                    <h4>Mewoo Activity Cushion</h4>
                    <p>₱1,250</p><button class="info-btn"
                        onclick="openInfo('Mewoo Activity Cushion', 'Designed for playful pets with soft surface.', '../products/PETBH/Mewoo - Playful Paws Pet Activity Cushion.png')">i</button>
                </div>

                <div class="card" data-category="Supplements" data-price="350"><img src="../products/VITA/Coat Shine Performance Enhancer for Dogs 120ml.png">
                    <h4>Coat Shine Performance Enhancer 120ml</h4>
                    <p>₱350</p><button class="info-btn"
                        onclick="openInfo('Coat Shine Enhancer', 'Enhances dog’s coat, making it shinier and healthier.', '../products/VITA/Coat Shine Performance Enhancer for Dogs 120ml.png')">i</button>
                </div>
                <div class="card" data-category="Supplements" data-price="500"><img src="../products/VITA/Liverolin Cat and Dog Appetite Enhancer 200ml.png">
                    <h4>Liverolin Cat and Dog Appetite Enhancer</h4>
                    <p>₱500</p><button class="info-btn"
                        onclick="openInfo('Liverolin Appetite Enhancer', 'Booster encourages pets to eat more willingly.', '../products/VITA/Liverolin Cat and Dog Appetite Enhancer 200ml.png')">i</button>
                </div>
                <div class="card" data-category="Supplements" data-price="450"><img src="../products/VITA/Canicee Pet Vitamin C Immune Booster 60ml (2 bottles).png">
                    <h4>Canicee Pet Vitamin C Booster</h4>
                    <p>₱450</p><button class="info-btn"
                        onclick="openInfo('Canicee Vitamin C', 'Supports the immune system in pets against illnesses.', '../products/VITA/Canicee Pet Vitamin C Immune Booster 60ml (2 bottles).png')">i</button>
                </div>
                <div class="card" data-category="Supplements" data-price="400"><img src="../products/VITA/Nutriblend Gel High-Energy Dietary Supplement Tube for Cats and Dogs 220g.png">
                    <h4>Nutriblend Gel High-Energy 220g</h4>
                    <p>₱400</p><button class="info-btn"
                        onclick="openInfo('Nutriblend Gel', 'Provides active pets with an instant energy boost.', '../products/VITA/Nutriblend Gel High-Energy Dietary Supplement Tube for Cats and Dogs 220g.png')">i</button>
                </div>
                <div class="card" data-category="Supplements" data-price="350"><img src="../products/VITA/Nutrical Calcium Supplement in Syrup 60ml.png">
                    <h4>Nutrical Calcium Supplement 60ml</h4>
                    <p>₱350</p><button class="info-btn"
                        onclick="openInfo('Nutrical Calcium', 'Supports strong bones and teeth, beneficial for growing puppies.', '../products/VITA/Nutrical Calcium Supplement in Syrup 60ml.png')">i</button>
                </div>
                <div class="card" data-category="Supplements" data-price="300"><img src="../products/VITA/Nutrivet Brewers Yeast 300 tabs.png">
                    <h4>Nutrivet Brewers Yeast 300 tabs</h4>
                    <p>₱300</p><button class="info-btn"
                        onclick="openInfo('Nutrivet Brewers Yeast', 'Promotes healthy skin and a shiny coat.', '../products/VITA/Nutrivet Brewers Yeast 300 tabs.png')">i</button>
                </div>
                <div class="card" data-category="Supplements" data-price="200"><img src="../products/VITA/My Pet Puppy Boost Energy Gel Complementary Feed for Puppies and Kittens 15ml.png">
                    <h4>My Pet Puppy Boost Energy Gel 15ml</h4>
                    <p>₱200</p><button class="info-btn"
                        onclick="openInfo('Puppy Boost Gel', 'Formulated for puppies and kittens to support growth.', '../products/VITA/My Pet Puppy Boost Energy Gel Complementary Feed for Puppies and Kittens 15ml.png')">i</button>
                </div>
                <div class="card" data-category="Supplements" data-price="350"><img src="../products/VITA/Iron Aid Pet Supplement 60ml.png">
                    <h4>Iron Aid Pet Supplement 60ml</h4>
                    <p>₱350</p><button class="info-btn"
                        onclick="openInfo('Iron Aid Pet Supplement', 'Supports healthy blood function and overall vitality.', '../products/VITA/Iron Aid Pet Supplement 60ml.png')">i</button>
                </div>
                <div class="card" data-category="Supplements" data-price="400"><img src="../products/VITA/Pet-C Ascorbic Acid Pet Vitamin C 120ml.png">
                    <h4>Pet-C Ascorbic Acid Vitamin C 120ml</h4>
                    <p>₱400</p><button class="info-btn"
                        onclick="openInfo('Pet-C Vitamin C', 'Boosts immune support in pets and general health.', '../products/VITA/Pet-C Ascorbic Acid Pet Vitamin C 120ml.png')">i</button>
                </div>
                <div class="card" data-category="Supplements" data-price="450"><img src="../products/VITA/Happy Tummy Probiotics for Dogs.png">
                    <h4>Probiotic Formula Support Supplement</h4>
                    <p>₱450</p><button class="info-btn"
                        onclick="openInfo('Probiotic Formula', 'Supports healthy digestion and maintains gut balance.', '../products/VITA/Happy Tummy Probiotics for Dogs.png')">i</button>
                </div>
            </div>

        </main>  
        </div>  




    <footer class="main-footer">
        <div class="follow-us-bar">
            <p>Follow us on</p>
            <div class="social-icons">
                <a href="https://www.facebook.com/pawsforkeepsbiz" target="_blank"><img src="../images/facebook.png"
                        alt="FB"></a>
                <a href="https://www.instagram.com/pawsforkeepsbiz" target="_blank"><img src="../images/instagram.png"
                        alt="IG"></a>
                <a href="https://x.com/pawsforkeeps" target="_blank"><img src="../images/twitter.png" alt="X"></a>
            </div>
        </div>
        <div class="footer-content">
            <div class="footer-grid">
                <div class="footer-col">
                    <h4 class="footer-brand">Paws For Keeps Pet Supplies and Accessories</h4>
                    <p>Our one-stop shop for premium pet essentials! From nutritious food to stylish accessories.</p>
                    <p class="hashtags">#PawsForKeeps #PetLovers</p>
                </div>
                <div class="footer-col">
                    <p>📞 0977 231 4361</p>
                    <p>✉️ pawsforkeeps.biz@gmail.com</p>
                    <p>🌐 FB: Paws For Keeps Pet Supplies</p>
                </div>
                <div class="footer-col links-col">
                    <a href="#">Privacy Policy</a>
                    <a href="#">Terms & Conditions</a>
                    <a href="#">Anti-Bribery Corruption Policy</a>
                </div>
            </div>
        </div>
        <div class="copyright-bar">2026 Paws For Keeps Pet Supplies. All Rights Reserved.</div>
    </footer>

    <div id="modal" class="modal">
        <div class="modal-content">
            <span class="close" onclick="closeModal()">&times;</span>
            <div class="modal-body-flex">
                <div class="modal-img-container"><img id="modal-img" src=""></div>
                <div class="modal-text-container">
                    <h3 id="modal-title"></h3>
                    <hr>
                    <p id="modal-desc"></p>
                </div>
            </div>
        </div>
    </div>

    <script>
        function filterCategory(cat) {
            const cards = document.querySelectorAll('.card');
            document.getElementById('currentCategory').innerText = cat;
            cards.forEach(card => {
                card.style.display = card.getAttribute('data-category') === cat ? "block" : "none";
            });
            window.scrollTo({ top: 0, behavior: 'smooth' });
        }

        function handleSearch(inputId) {
            const q = document.getElementById(inputId).value.toLowerCase();
            const cards = document.querySelectorAll('.card');
            cards.forEach(c => {
                const name = c.querySelector('h4').innerText.toLowerCase();
                c.style.display = name.includes(q) ? "block" : "none";
            });
        }

        function handleSort() {
            const grid = document.getElementById('productGrid');
            const cards = Array.from(grid.getElementsByClassName('card'));
            const mode = document.getElementById('sortSelect').value;
            if (mode === 'default') return;
            cards.sort((a, b) => {
                const priceA = parseInt(a.getAttribute('data-price'));
                const priceB = parseInt(b.getAttribute('data-price'));
                return mode === 'low' ? priceA - priceB : priceB - priceA;
            });
            cards.forEach(card => grid.appendChild(card));
        }

        function openInfo(t, d, s) {
            document.getElementById("modal").style.display = "block";
            document.getElementById("modal-title").innerText = t;
            document.getElementById("modal-desc").innerText = d;
            document.getElementById("modal-img").src = s;
        }

        function closeModal() { document.getElementById("modal").style.display = "none"; }
        window.onload = () => filterCategory('Food');
        window.onclick = (e) => { if (e.target == document.getElementById("modal")) closeModal(); }
    </script>

    <script src="search.js"></script>
</body>

</html>