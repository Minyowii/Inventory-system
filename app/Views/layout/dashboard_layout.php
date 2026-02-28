<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?= $title; ?></title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600;700&display=swap" rel="stylesheet">
    <style>
        :root {
            --primary-color: #4DB6AC;
            --secondary-color: #F06292;
            --accent-color: #FFB74D;
            --bg-color: #E0F2F1;
            --sidebar-bg: #FFFFFF;
            --sidebar-text: #37474F;
            --card-shadow: 0 8px 30px rgba(0,0,0,0.05);
            --transition: all 0.3s ease;
        }

        body { 
            background-color: var(--bg-color); 
            font-family: 'Poppins', sans-serif; 
            color: #37474F;
            overflow-x: hidden;
        }

        #wrapper { display: flex; width: 100%; align-items: stretch; }

        #sidebar { 
            min-width: 280px; 
            max-width: 280px; 
            background: var(--sidebar-bg); 
            color: var(--sidebar-text); 
            transition: var(--transition); 
            min-height: 100vh;
            box-shadow: 4px 0 20px rgba(0,0,0,0.02);
            z-index: 1000;
        }

        #sidebar.active { margin-left: -280px; }

        .sidebar-header { 
            padding: 30px 20px; 
            text-align: center; 
            border-bottom: 1px solid #F1F1F1;
        }

        .sidebar-header h4 {
            font-weight: 700;
            color: var(--primary-color);
            letter-spacing: 1px;
            margin: 0;
        }

        #sidebar ul { padding: 20px 0; }

        #sidebar ul li a { 
            padding: 12px 30px; 
            display: flex;
            align-items: center;
            color: var(--sidebar-text); 
            text-decoration: none; 
            font-weight: 500;
            transition: var(--transition);
            border-left: 4px solid transparent;
            margin-bottom: 5px;
        }

        #sidebar ul li a i { width: 25px; font-size: 1.1rem; margin-right: 15px; }

        #sidebar ul li a:hover, #sidebar ul li.active a { 
            background: #F5FBFB; 
            color: var(--primary-color);
            border-left-color: var(--primary-color);
        }

        #sidebar ul li a.logout-link { color: #E57373; }
        #sidebar ul li a.logout-link:hover { background: #FFEBEE; }

        #content { width: 100%; padding: 30px; transition: var(--transition); }

        .navbar { 
            background: transparent; 
            border: none;
            margin-bottom: 30px; 
            padding: 0;
        }

        .btn-toggle {
            background: #fff;
            border: none;
            width: 45px;
            height: 45px;
            border-radius: 12px;
            display: flex;
            align-items: center;
            justify-content: center;
            box-shadow: var(--card-shadow);
            color: var(--primary-color);
            transition: var(--transition);
        }

        .btn-toggle:hover { background: var(--primary-color); color: #fff; }

        .welcome-text { font-weight: 600; color: #455A64; }

        /* Custom Scrollbar */
        ::-webkit-scrollbar { width: 8px; }
        ::-webkit-scrollbar-track { background: #f1f1f1; }
        ::-webkit-scrollbar-thumb { background: #ccc; border-radius: 10px; }
        ::-webkit-scrollbar-thumb:hover { background: var(--primary-color); }

        @media (max-width: 768px) {
            #sidebar { margin-left: -280px; }
            #sidebar.active { margin-left: 0; }
            #content { padding: 20px; }
        }
    </style>
</head>
<body>
    <div id="wrapper">
        <nav id="sidebar">
            <div class="sidebar-header">
                <h4>STOCK MANAGER</h4>
            </div>
            <ul class="list-unstyled">
                <li class="<?= (isset($title) && $title == 'Dashboard') ? 'active' : '' ?>">
                    <a href="<?= base_url('dashboard') ?>"><i class="fa fa-th-large"></i> Dashboard</a>
                </li>
                
                <?php if (session()->get('role') == 'admin') : ?>
                    <li><a href="<?= base_url('inventory') ?>"><i class="fa fa-box"></i> Multi Products</a></li>
                    <li><a href="<?= base_url('categories') ?>"><i class="fa fa-tag"></i> Categories</a></li>
                    <li><a href="<?= base_url('suppliers') ?>"><i class="fa fa-truck"></i> Suppliers</a></li>
                    <li><a href="<?= base_url('orders/manage') ?>"><i class="fa fa-history"></i> All Transactions</a></li>
                <?php else : ?>
                    <li><a href="<?= base_url('inventory') ?>"><i class="fa fa-shopping-basket"></i> Buy Items</a></li>
                    <li>
                        <a href="<?= base_url('orders/cart') ?>" class="position-relative">
                            <i class="fa fa-shopping-cart"></i> My Cart
                            <?php if(session()->get('cart')): ?>
                                <span class="badge rounded-pill bg-danger" style="font-size: 0.6rem; position: absolute; top: 8px; right: 20px;"><?= count(session()->get('cart')) ?></span>
                            <?php endif; ?>
                        </a>
                    </li>
                    <li><a href="<?= base_url('orders') ?>"><i class="fa fa-receipt"></i> My Orders</a></li>
                <?php endif; ?>
                
                <li><a href="<?= base_url('profile') ?>"><i class="fa fa-cog"></i> Settings</a></li>
                <li class="mt-4"><a href="<?= base_url('logout') ?>" class="logout-link"><i class="fa fa-sign-out-alt"></i> Logout</a></li>
            </ul>
        </nav>

        <div id="content">
            <nav class="navbar navbar-expand-lg">
                <button type="button" id="sidebarCollapse" class="btn-toggle">
                    <i class="fa fa-bars"></i>
                </button>
                <div class="ms-3">
                    <h5 class="m-0 welcome-text">Hello, <?= session()->get('username') ?> 👋</h5>
                    <small class="text-muted">Manage your stock and inventory easily</small>
                </div>
            </nav>

            <?php if(session()->getFlashdata('success')): ?>
                <div class="alert alert-success alert-dismissible fade show border-0 shadow-sm" style="border-radius: 12px; background: #E8F5E9; color: #2E7D32;">
                    <i class="fa fa-check-circle me-2"></i> <?= session()->getFlashdata('success') ?>
                    <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
                </div>
            <?php endif; ?>

            <?= $this->renderSection('content') ?>
        </div>
    </div>
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
    <script>
        $(document).ready(function () {
            $('#sidebarCollapse').on('click', function () { $('#sidebar').toggleClass('active'); });
        });
    </script>
</body>
</html>