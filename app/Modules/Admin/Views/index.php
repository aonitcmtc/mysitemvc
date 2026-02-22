<style>
    /* #end_node { visibility: hidden;} */
    /* style costom only page */
    @media (max-width: 900px) {

        .d-workspace {
            height: auto;
            max-height: 100vh; /* grows with content but capped */
            overflow-y: auto;

        }

        .d-navbar { padding: 0 8px;}

        .mindmap {
            height: 180px;
        }

        #company {z-index: 16; top: 110%; left: 50%;  transform: translateX(-50%);}
        #risk {z-index: 15; top: 160%; left: 50%;  transform: translateX(-50%);}
        #business {z-index: 14; top: 210%; left: 50%;  transform: translateX(-50%);}
        #management {z-index: 13; top: 260%; left: 50%;  transform: translateX(-50%);}
        #finances {z-index: 12; top: 310%; left: 50%;  transform: translateX(-50%);}
        #market {z-index: 11; top: 360%; left: 50%;  transform: translateX(-50%);}
        #products {z-index: 10; top: 410%; left: 50%;  transform: translateX(-50%);}
        /* #end_node {top: 450%; left: 50%;  transform: translateX(-50%); height:20px;} */
    }
</style>

<div class="container">
    <div class="row">
        <div class="col-12 mt-5 pt-3">
            <nav aria-label="breadcrumb">
                <ol class="breadcrumb rounded-pill bg-96A7E8 px-3">
                    <li class="breadcrumb-item"><a class="text-decoration-none" href="/admin/">Home</a></li>
                    <!-- <li class="breadcrumb-item active" aria-current="page">Dashboard</li> -->
                </ol>

                <!-- <ol class="breadcrumb">
                    <li class="breadcrumb-item"><a class="text-decoration-none" href="admin/">Home</a></li>
                    <li class="breadcrumb-item"><a class="text-decoration-none" href="#">statistic</a></li>
                    <li class="breadcrumb-item active" aria-current="page">user</li>
                </ol> -->
            </nav>
        </div>
    </div>
    <div class="row justify-content-end">
        <div class="col-12">
            <div class="d-dashboard text-center">
                <h4>Admin Center</h4>
                <h6>color tone</h6>

                <botton class="btn btn-sm bd-87A bg-87A2FF">#87A2FF</botton>
                <botton class="btn btn-sm bd-87A bg-C4D7FF">#C4D7FF</botton>
                <botton class="btn btn-sm bd-87A bg-BD8843">#BD8843</botton>
                <botton class="btn btn-sm bd-87A bg-C89780">#C89780</botton>

                <div class="col-12 text-center m-3">
                    <label for="selectColor" class="form-label">Select Color</label>
                    <input type="color" class="form-control-color" id="selectColor" value="#87A2FF" title="Choose your color">
                </div>

                <div class="d-workspace">
                    <div class="container">
                        <h1>Business Planning Mind Map</h1>
                        <div class="subtitle">
                            <h4 class="text-secondary">Welcome to admin page.</h4>
                        </div>
                        <div class="mindmap">
                            <div class="center">
                                Work<br>Space
                            </div>

                            <!-- Lines will be created with JS -->
                            <div class="node" id="company">
                                <div class="node-title">Company Profile</div>
                                <div class="node-content">
                                    • <a class="text-decoration-none text-light" href="#Who_we_are">Who we are</a><br>
                                    • <a class="text-decoration-none text-light" href="#Company_history">Company history</a><br>
                                    • <a class="text-decoration-none text-light" href="#Company_ownership">Company ownership</a><br>
                                    • <a class="text-decoration-none text-light" href="#Location">Location</a>
                                </div>
                            </div>

                            <div class="node" id="management">
                                <div class="node-title">Management</div>
                                <div class="node-content">
                                    • <a class="text-decoration-none text-light" href="#Organizational_structure">Organizational structure</a><br>
                                    • <a class="text-decoration-none text-light" href="#Managerial_team">Managerial team</a><br>
                                    • <a class="text-decoration-none text-light" href="/admin/dashboard">Dashboard</a><br>
                                    • <a class="text-decoration-none text-light" href="/admin/users">User</a><br>
                                    • <a class="text-decoration-none text-light" href="/admin/report">Report</a><br>
                                    • <a class="text-decoration-none text-light" href="/admin/apitest">API test</a><br>
                                    <!-- • <a class="text-decoration-none text-light" href="#aaaa1">AAA</a><br>
                                    • <a class="text-decoration-none text-light" href="#aaaa3">BBB</a><br>
                                    • <a class="text-decoration-none text-light" href="#aaaa3">CCC</a> -->
                                </div>
                            </div>

                            <div class="node" id="finances">
                                <div class="node-title">Finances</div>
                                <div class="node-content">
                                    • <a class="text-decoration-none text-light" href="#Funding">Funding</a><br>
                                    • <a class="text-decoration-none text-light" href="#Key_financial_indicators">Key financial indicators</a><br>
                                    • <a class="text-decoration-none text-light" href="#Break-even_analysis">Break-even analysis</a><br>
                                    • <a class="text-decoration-none text-light" href="#Profit/loss">Profit / loss</a><br>
                                    • <a class="text-decoration-none text-light" href="#Balance_sheet">Balance sheet</a><br>
                                    • <a class="text-decoration-none text-light" href="#Cash_flow">Cash flow</a><br>
                                    • <a class="text-decoration-none text-light" href="#Payment_plan">Payment plan</a>
                                </div>
                            </div>

                            <div class="node" id="products">
                                <div class="node-title">Products & Services</div>
                                <div class="node-content">
                                    • <a class="text-decoration-none text-light" href="#Competitive_analysis">Competitive analysis</a><br>
                                    • <a class="text-decoration-none text-light" href="#Sales_literature">Sales literature</a><br>
                                    • <a class="text-decoration-none text-light" href="#Usability">Usability</a><br>
                                    • <a class="text-decoration-none text-light" href="#Technology">Technology</a><br>
                                    • <a class="text-decoration-none text-light" href="/admin/framsv1">Fram serviver</a><br>
                                    • <a class="text-decoration-none text-light" href="/admin/mario">Simple mario</a><br>
                                    • <a class="text-decoration-none text-light" href="/admin/snake">Snake</a>
                                </div>
                            </div>

                            <div class="node" id="market">
                                <div class="node-title">Market</div>
                                <div class="node-content">
                                    • <a class="text-decoration-none text-light" href="#Demographics">Demographics</a><br>
                                    • <a class="text-decoration-none text-light" href="#Psychographics">Psychographics</a><br>
                                    • <a class="text-decoration-none text-light" href="#Competition">Competition</a><br>
                                    • <a class="text-decoration-none text-light" href="#Customer">Customer</a><br>
                                    • <a class="text-decoration-none text-light" href="/admin/chartlist">Chart list</a><br>
                                    • <a class="text-decoration-none text-light" href="/admin/chart/xauusd">XAUUSD</a><br>
                                    • <a class="text-decoration-none text-light" href="/admin/chart/xauusdclassic">XAUUSD Classic</a><br>
                                    • <a class="text-decoration-none text-light" href="/admin/chart/chartgoldthai">Gold thai</a>
                                    
                                </div>
                            </div>

                            <div class="node" id="business">
                                <div class="node-title">Business Model</div>
                                <div class="node-content">
                                    • <a class="text-decoration-none text-light" href="#Value">Value</a><br>
                                    • <a class="text-decoration-none text-light" href="#Customers">Customers</a><br>
                                    • <a class="text-decoration-none text-light" href="#Channels">Channels</a><br>
                                    • <a class="text-decoration-none text-light" href="#Customer_relationships">Customer relationships</a><br>
                                    • <a class="text-decoration-none text-light" href="#Resources">Resources</a><br>
                                    • <a class="text-decoration-none text-light" href="#Partners">Partners</a><br>
                                    • <a class="text-decoration-none text-light" href="#Cost_structures">Cost structures</a><br>
                                    • <a class="text-decoration-none text-light" href="#Revenue_streams">Revenue streams</a><br>
                                    • <a class="text-decoration-none text-light" href="/admin/devcode">Test Code</a>
                                </div>
                            </div>

                            <div class="node" id="risk">
                                <div class="node-title">Risk Management</div>
                                <div class="node-content">
                                    • <a class="text-decoration-none text-light" href="#Risk_areas">Risk areas</a><br>
                                    • <a class="text-decoration-none text-light" href="#Risk_indicators">Risk indicators</a><br>
                                    • <a class="text-decoration-none text-light" href="#Measurement_analysis">Measurement analysis</a><br>
                                    • <a class="text-decoration-none text-light" href="#Revision">Revision</a>
                                </div>
                            </div>

                            <!-- <div id="end_node" class="node"></div> -->
                        </div>

                        <div style="margin-top:60px; color:#64748b; font-size:0.9rem;">
                            workspace design by 
                            <a href="https://grok.com" class="text-decoration-none text-secondary" target="_blank" rel="grok_AI">grok</a>
                        </div>
                    </div>
                </div>
            </div>
            
        </div>
    </div>
</div>

<!-- <script type="module" src="cookieconsent-config.js"></script> -->
<!-- <script type="module" src="./../asset/iscookie/cookieconsent-config.js"></script> -->
<!-- <script type="module" src="/asset/"></script> -->
 
<script>
    document.querySelectorAll('.node').forEach(node => {
        node.addEventListener('click', () => {
            node.classList.toggle('active');
        });
    });

    // Optional: draw connecting lines (simple version)
    const center = document.querySelector('.center');
    const nodes = document.querySelectorAll('.node');

    nodes.forEach(node => {
        const line = document.createElement('span');
        line.className = 'line';
        document.querySelector('.mindmap').appendChild(line);

        function updateLine() {
        const cRect = center.getBoundingClientRect();
        const nRect = node.getBoundingClientRect();
        const parentRect = document.querySelector('.mindmap').getBoundingClientRect();

        const cX = cRect.left + cRect.width/2 - parentRect.left;
        const cY = cRect.top  + cRect.height/2 - parentRect.top;
        const nX = nRect.left + nRect.width/2  - parentRect.left;
        const nY = nRect.top  + nRect.height/2  - parentRect.top;

        const length = Math.sqrt((nX - cX)**2 + (nY - cY)**2);
        const angle  = Math.atan2(nY - cY, nX - cX) * 180 / Math.PI;

        line.style.width = length + 'px';
        line.style.left  = cX + 'px';
        line.style.top   = cY + 'px';
        line.style.transform = `rotate(${angle}deg)`;
        }

        updateLine();
        window.addEventListener('resize', updateLine);
    });
</script>