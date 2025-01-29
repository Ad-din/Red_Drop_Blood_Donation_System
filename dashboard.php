<?php 
session_start();

include './phpFiles/config.php';

?>

<head>
   
    <style>
        /* grid container */
.holy-grail-grid {
    display:grid;
    grid-template-areas:
        'header'
        'main-content'
        'left-sidebar'
        'right-sidebar'
        'footer';
}

/* general column padding */
.holy-grail-grid > * {
    
}

/* assign columns to grid areas */
.holy-grail-grid > .header {
    grid-area:header;
    width:100%;
    
}
.holy-grail-grid > .main-content {
    grid-area:main-content;
    background:#fff;
    text-align: center;
}
.holy-grail-grid > .left-sidebar {
    grid-area:left-sidebar;
    
}
.holy-grail-grid > .right-sidebar {
    grid-area:right-sidebar;
   
}
.holy-grail-grid > .footer {
    grid-area:footer;
    background:#72c2f1;
}

/* tablet breakpoint */
@media (min-width:768px) {
    .holy-grail-grid {
        grid-template-columns: 1fr 1fr;
        grid-template-areas:
            'header header'
            'main-content main-content'
            'left-sidebar right-sidebar'
            'footer footer';
    }
}

/* desktop breakpoint */
@media (min-width:1024px) {
    .holy-grail-grid {
        grid-template-columns: repeat(4, 1fr);
        grid-template-areas:
            'header header header header'
            'left-sidebar main-content main-content right-sidebar'
            'footer footer footer footer';
    }
}

    </style>
</head>

<div class="holy-grail-grid">
    <header class="header"><?php include 'header.php'?></header>
    <main class="main-content">

    <?php include('showPost.php')?>


    </main>
    <section class="left-sidebar"><?php include 'sidebar.php'?></section>
    <aside class="right-sidebar"></aside>
    <footer class="footer">Footer</footer>
</div>