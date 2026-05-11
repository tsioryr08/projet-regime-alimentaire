<style>
        :root {
            --sage: #a9cdb1;
            --sage-dark: #6f927b;
            --sage-soft: #eef6ef;
            --pink: #f4c6d6;
            --pink-dark: #c984a1;
            --pink-soft: #fff3f7;
            --ink: #203026;
        }

        * {
            box-sizing: border-box;
        }

        body {
            margin: 0;
            min-height: 100vh;
            font-family: 'Poppins', sans-serif;
            background:
                radial-gradient(circle at top left, rgba(169, 205, 177, .55), transparent 34%),
                radial-gradient(circle at bottom right, rgba(244, 198, 214, .60), transparent 36%),
                linear-gradient(180deg, #fbfcfb 0%, #fff7fa 100%);
            color: var(--ink);
        }

        .topbar {
            position: sticky;
            top: 0;
            z-index: 20;
            backdrop-filter: blur(16px);
            background: rgba(255, 255, 255, .72);
            border-bottom: 1px solid rgba(111, 146, 123, .14);
        }

        .brand {
            font-weight: 800;
            letter-spacing: .3px;
            color: var(--ink) !important;
        }

        .brand span {
            color: var(--sage-dark);
        }

        .nav-link {
            color: #4b5a51 !important;
            font-weight: 600;
        }

        .nav-link:hover {
            color: var(--sage-dark) !important;
        }

        .logout-btn {
            background: linear-gradient(135deg, var(--pink) 0%, #e9adc2 100%);
            color: #6f3f57 !important;
            border: 1px solid rgba(201, 132, 161, .24);
            transition: .2s ease;
        }

        .logout-btn:hover {
            color: #5e3648 !important;
            transform: translateY(-1px);
            box-shadow: 0 10px 20px rgba(244, 198, 214, .28);
        }

        .img-logo{
            width: 22px;
            height: 22px;
            object-fit: contain;
            margin-right: 6px;
        }
</style>
