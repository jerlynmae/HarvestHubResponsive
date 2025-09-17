<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0"/>
  <title>HarvestHub - Fresh Goods</title>
  <link rel="stylesheet" href="css/style.css?v=<?= time() ?>">
</head>
<body>
  <!-- NAV -->
  <header class="nav-wrap">
    <div class="container nav">
      <div class="brand">HarvestHub</div>
      <nav class="nav-links" id="navLinks">
        <a href="#">Home</a>
        <a href="#">Shop</a>
        <a href="#">About</a>
        <a href="#">Contact</a>
        <a href="login.php" class="btn small">Login</a>
        <a href="createaccount.php"class="btn small">Signup</a>
      </nav>
      <button class="nav-toggle" id="navToggle">☰</button>
    </div>
  </header>

  <!-- HERO -->
  <section class="hero container">
    <div>
      <h1>Fresh & Organic from Local Farms</h1>
      <p>Direct from farmer to table — sustainable, fresh, and affordable.</p>
      <a href="#shop" class="btn">Shop Now</a>
    </div>
    <div>
      <img src="img/vege.png" alt="Organic produce"/>
    </div>
  </section>

  <!-- SHOP -->
  <main class="container">
    <div class="section-head">
      <h2>Featured Products</h2>
      <div class="search-filter">
        <input id="search" type="search" placeholder="Search products..." />
        <select id="category" name="category" class="category">
          <option value="all">All categories</option>
          <option value="vegetables">High Valued Products</option>
          <option value="fruits">Fruits</option>
        </select>
      </div>
    </div>

    <div class="products-grid" id="productsGrid"></div>
  </main>

  <!-- PROMO SECTION -->
<section class="promo container">
  <div class="promo-card">
    <div class="promo-text">
      <h4>UP TO 25% OFF</h4>
      <h2>Fresh vegetables package.</h2>
      <a href="#" class="btn">Shop Now</a>
    </div>
    <div class="promo-img">
      <img src="img/container.png" alt="Vegetable Package">
    </div>
  </div>

  <div class="promo-card">
    <div class="promo-text">
      <h4>UP TO 25% OFF</h4>
      <h2>Healthy & fresh Fruits.</h2>
      <a href="#" class="btn">Shop Now</a>
    </div>
    <div class="promo-img">
      <img src="img/fruit.png" alt="Fresh Beef">
    </div>
  </div>
</section>
    <!-- ABOUT -->
  <section class="about container" id="about">
    <div class="about-content">
      <h2>About HarvestHub</h2>
      <p>
        HarvestHub connects local farmers directly with customers.  
        Our mission is to support sustainable farming while making fresh, organic, 
        and affordable produce accessible to everyone.  
      </p>
      <p>
        By choosing HarvestHub, you’re not only getting fresh goods but also helping 
        farmers earn fair income for their hard work. 
      </p>
    </div>
    <div class="about-img">
      <img src="img/harvesting.jpg" alt="Farmers harvesting">
    </div>
  </section>
  <!-- BLOG / TIPS SECTION -->
<section class="blog container" id="blog">
  <h2 class="section-title">Fresh Tips & Articles</h2>
  <div class="blog-grid">
    
    <article class="blog-card">
      <img src="img/health.jpg" alt="Health Benefits of Vegetables">
      <div class="blog-content">
        <h3>5 Health Benefits of Organic Vegetables</h3>
        <p>Discover how fresh organic vegetables can boost your health and immune system.</p>
        <a href="#" class="read-more">Read More →</a>
      </div>
    </article>

    <article class="blog-card">
      <img src="img/support.jpg" alt="Support Local Farmers">
      <div class="blog-content">
        <h3>Why Support Local Farmers?</h3>
        <p>Buying directly from farmers means fair income and fresher produce for you.</p>
        <a href="#" class="read-more">Read More →</a>
      </div>
    </article>

    <article class="blog-card">
      <img src="img/how.jpg" alt="Tips for Fresh Fruits">
      <div class="blog-content">
        <h3>How to Choose the Freshest Fruits</h3>
        <p>Learn simple tricks to select the best seasonal fruits in the market.</p>
        <a href="#" class="read-more">Read More →</a>
      </div>
    </article>

  </div>
</section>

  <!-- FOOTER -->
  <footer class="footer">
    <div class="container">
      <div>© <span id="year"></span> HarvestHub</div>
      <div class="footer-links">
        <a href="#">Privacy</a>
        <a href="#">Terms</a>
        <a href="#">Help</a>
      </div>
    </div>
  </footer>

  <script>
    const products = [
      {id:1,name:"Vine Tomato",category:"vegetables",price:65,img:"img/tomato.jpg"},
      {id:2,name:"Organic Banana",category:"fruits",price:120,img:"img/banana.jpg"},
      {id:4,name:"Kangkong Bunch",category:"vegetables",price:40,img:"img/kangkong.png"},
      {id:5,name:"Sweet Mango",category:"fruits",price:150,img:"img/mango.jpg"},
      {id:1,name:"Vine Tomato",category:"vegetables",price:65,img:"img/tomato.jpg"},
      {id:2,name:"Organic Banana",category:"fruits",price:120,img:"img/banana.jpg"},
      {id:4,name:"Kangkong Bunch",category:"vegetables",price:40,img:"img/kangkong.png"},
      {id:5,name:"Sweet Mango",category:"fruits",price:150,img:"img/mango.jpg"},
    ];
    const grid=document.getElementById('productsGrid');
    const search=document.getElementById('search');
    const category=document.getElementById('category');
    const cartBtn=document.getElementById('cartBtn');
    const navToggle=document.getElementById('navToggle');
    const navLinks=document.getElementById('navLinks');
    let cartCount=0;

    function render(items){
      grid.innerHTML=items.map(p=>`
        <article class="card">
          <img src="${p.img}" alt="${p.name}">
          <div class="card-content">
            <h3>${p.name}</h3>
            <div class="price-row">
              <div class="price">₱ ${p.price.toFixed(2)}</div>
              <button class="add" data-id="${p.id}">Find Similar?</button>
            </div>
          </div>
        </article>
      `).join('');
    }
    function filter(){
      const q=search.value.trim().toLowerCase();
      const cat=category.value;
      const out=products.filter(p=>{
        const matchQ=p.name.toLowerCase().includes(q);
        const matchCat=(cat==='all')?true:p.category===cat;
        return matchQ&&matchCat;
      });
      render(out);
    }

    search.addEventListener('input',filter);
    category.addEventListener('change',filter);
    navToggle.addEventListener('click',()=>{
      navLinks.style.display=(navLinks.style.display==='flex')?'none':'flex';
    });

    render(products);
    document.getElementById('year').textContent=new Date().getFullYear();
  </script>
</body>
</html>
