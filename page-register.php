<?php
/* Template Name: Register */
get_header();
?>
<style>
.reg-wrap{min-height:100vh;background:var(--ink);display:flex;align-items:center;justify-content:center;padding:80px 20px 60px}
.reg-card{width:100%;max-width:480px}
.reg-logo{text-align:center;margin-bottom:32px}
.reg-logo a{font-family:var(--headline);font-size:28px;color:var(--rust);letter-spacing:3px;text-decoration:none}
.reg-logo p{font-size:11px;color:rgba(255,255,255,.35);letter-spacing:2px;margin-top:4px}
.reg-box{background:#0f0d0b;border:1px solid rgba(193,68,14,.25);border-radius:4px;padding:36px 32px}
.reg-tag{font-size:10px;letter-spacing:3px;text-transform:uppercase;color:var(--rust);margin-bottom:8px}
.reg-title{font-family:var(--headline);font-size:28px;color:#fff;letter-spacing:1px;margin-bottom:6px}
.reg-sub{font-size:13px;color:rgba(255,255,255,.4);line-height:1.6;margin-bottom:28px}
.reg-field{margin-bottom:16px}
.reg-field label{display:block;font-size:10px;letter-spacing:2px;text-transform:uppercase;color:rgba(255,255,255,.4);margin-bottom:6px}
.reg-field input,.reg-field select{width:100%;box-sizing:border-box;padding:12px 14px;background:rgba(255,255,255,.06);border:1px solid rgba(255,255,255,.12);color:#fff;font-family:var(--body);font-size:14px;border-radius:2px;outline:none;transition:border-color .2s}
.reg-field input:focus,.reg-field select:focus{border-color:rgba(193,68,14,.6)}
.reg-field input::placeholder{color:rgba(255,255,255,.2)}
.reg-field select option{background:#1a1410;color:#fff}
.reg-row{display:grid;grid-template-columns:1fr 1fr;gap:12px}
.reg-btn{width:100%;padding:14px;background:var(--rust);border:none;color:#fff;font-family:var(--headline);font-size:18px;letter-spacing:2px;cursor:pointer;border-radius:2px;transition:background .2s;margin-top:8px}
.reg-btn:hover:not(:disabled){background:#a03508}
.reg-btn:disabled{opacity:.55;cursor:not-allowed}
.reg-msg{font-size:12px;margin-top:12px;text-align:center;min-height:18px}
.reg-msg.error{color:#f87171}
.reg-msg.success{color:#4ade80}
.reg-step{display:none}
.reg-step.active{display:block}
.pw-wrap{position:relative}
.pw-wrap input{padding-right:44px}
.pw-toggle{position:absolute;right:12px;top:50%;transform:translateY(-50%);background:none;border:none;color:rgba(255,255,255,.35);cursor:pointer;font-size:16px;padding:4px}
.pw-strength{height:3px;border-radius:2px;margin-top:6px;background:rgba(255,255,255,.08);overflow:hidden}
.pw-strength-bar{height:100%;border-radius:2px;transition:width .3s,background .3s;width:0}
/* Phone with country code */
.phone-wrap{display:flex;gap:8px}
.phone-wrap .cc-select{width:130px;flex-shrink:0;padding:12px 8px;background:rgba(255,255,255,.06);border:1px solid rgba(255,255,255,.12);color:#fff;font-size:13px;border-radius:2px;outline:none;cursor:pointer}
.phone-wrap .cc-select:focus{border-color:rgba(193,68,14,.6)}
.phone-wrap input{flex:1}
/* Autocomplete dropdown */
.ac-wrap{position:relative}
.ac-list{position:absolute;top:100%;left:0;right:0;background:#1a1410;border:1px solid rgba(193,68,14,.3);border-top:none;border-radius:0 0 2px 2px;max-height:180px;overflow-y:auto;z-index:100;display:none}
.ac-list.open{display:block}
.ac-item{padding:10px 14px;font-size:13px;color:rgba(255,255,255,.8);cursor:pointer;border-bottom:1px solid rgba(255,255,255,.05)}
.ac-item:hover,.ac-item.active{background:rgba(193,68,14,.2);color:#fff}
.ac-loading{padding:10px 14px;font-size:12px;color:rgba(255,255,255,.35);font-style:italic}
@media(max-width:520px){.reg-box{padding:28px 20px}.reg-row{grid-template-columns:1fr}.phone-wrap{flex-direction:column}.phone-wrap .cc-select{width:100%}}
</style>

<div class="reg-wrap">
  <div class="reg-card">

    <div class="reg-logo">
      <a href="<?php echo esc_url(home_url('/')); ?>">FREEWHEEL</a>
      <p>EXPEDITIONS</p>
    </div>

    <!-- STEP 1 -->
    <div id="regStep1" class="reg-step active">
      <div class="reg-box">
        <div class="reg-tag">Join the Community</div>
        <div class="reg-title">Create Account</div>
        <p class="reg-sub">Fill in your details below to join the FreeWheel community.</p>

        <div class="reg-row">
          <div class="reg-field">
            <label>First Name <span style="color:var(--rust)">*</span></label>
            <input type="text" id="regFirstName" placeholder="Rahul" autocomplete="given-name">
          </div>
          <div class="reg-field">
            <label>Last Name</label>
            <input type="text" id="regLastName" placeholder="Sharma" autocomplete="family-name">
          </div>
        </div>

        <div class="reg-field">
          <label>Email Address <span style="color:var(--rust)">*</span></label>
          <input type="email" id="regEmail" placeholder="rahul@gmail.com" autocomplete="email">
        </div>

        <div class="reg-field">
          <label>Password <span style="color:var(--rust)">*</span></label>
          <div class="pw-wrap">
            <input type="password" id="regPassword" placeholder="Min. 8 characters" autocomplete="new-password">
            <button type="button" class="pw-toggle" onclick="togglePw('regPassword',this)">👁</button>
          </div>
          <div class="pw-strength"><div class="pw-strength-bar" id="pwBar"></div></div>
        </div>

        <div class="reg-field">
          <label>Confirm Password <span style="color:var(--rust)">*</span></label>
          <div class="pw-wrap">
            <input type="password" id="regPassword2" placeholder="Repeat password" autocomplete="new-password">
            <button type="button" class="pw-toggle" onclick="togglePw('regPassword2',this)">👁</button>
          </div>
        </div>

        <div class="reg-field">
          <label>Phone Number</label>
          <div class="phone-wrap">
            <select id="regCountryCode" class="cc-select" onchange="onCountryCodeChange()">
              <!-- populated by JS -->
            </select>
            <input type="tel" id="regPhone" placeholder="9876543210" inputmode="numeric">
          </div>
        </div>

        <div class="reg-field">
          <label>Country</label>
          <div class="ac-wrap">
            <input type="text" id="regCountryInput" placeholder="Search country…" autocomplete="off" oninput="acSearch('country',this.value)" onfocus="acSearch('country',this.value)" onkeydown="acKeyNav('country',event)">
            <input type="hidden" id="regCountry" value="India">
            <div class="ac-list" id="acListCountry"></div>
          </div>
        </div>

        <div class="reg-row">
          <div class="reg-field">
            <label>State</label>
            <div class="ac-wrap">
              <input type="text" id="regStateInput" placeholder="Search state…" autocomplete="off" oninput="acSearch('state',this.value)" onfocus="acSearch('state',this.value)" onkeydown="acKeyNav('state',event)">
              <input type="hidden" id="regState" value="">
              <div class="ac-list" id="acListState"></div>
            </div>
          </div>
          <div class="reg-field">
            <label>City</label>
            <div class="ac-wrap">
              <input type="text" id="regCityInput" placeholder="Search city…" autocomplete="off" oninput="acSearch('city',this.value)" onfocus="acSearch('city',this.value)" onkeydown="acKeyNav('city',event)">
              <input type="hidden" id="regCity" value="">
              <div class="ac-list" id="acListCity"></div>
            </div>
          </div>
        </div>

        <button class="reg-btn" id="regBtn1" onclick="regSubmitDetails()">CREATE ACCOUNT →</button>
        <div class="reg-msg" id="regMsg1"></div>
      </div>

      <div style="margin-top:16px;background:#0f0d0b;border:1px solid rgba(255,255,255,.12);border-radius:4px;padding:20px;display:flex;align-items:center;justify-content:space-between;gap:12px">
        <div>
          <div style="font-size:13px;color:rgba(255,255,255,.6)">Already have an account?</div>
          <div style="font-size:12px;color:rgba(255,255,255,.35);margin-top:2px">Log in to access your dashboard</div>
        </div>
        <a href="<?php echo esc_url(home_url('/login/')); ?>" style="display:inline-block;padding:11px 22px;background:transparent;border:1px solid var(--rust);color:var(--rust);font-family:var(--headline);font-size:14px;letter-spacing:2px;text-decoration:none;border-radius:2px;white-space:nowrap;transition:background .2s" onmouseover="this.style.background='rgba(193,68,14,.15)'" onmouseout="this.style.background='transparent'">LOG IN →</a>
      </div>
      <div class="reg-msg" style="margin-top:14px;color:rgba(255,255,255,.25)">By registering you agree to our <a href="<?php echo esc_url(home_url('/terms/')); ?>" style="color:rgba(193,68,14,.6)">terms of use</a></div>
    </div>

    <!-- STEP 2: Email Verification -->
    <div id="regStep2" class="reg-step">
      <div class="reg-box" style="text-align:center">
        <div style="font-size:48px;margin-bottom:16px">📧</div>
        <div class="reg-tag" style="text-align:center">Almost There</div>
        <div class="reg-title" style="text-align:center">Verify Your Email</div>
        <p class="reg-sub" style="text-align:center" id="regVerifyMsg">We've sent a confirmation link to your email.</p>
        <a href="<?php echo esc_url(home_url('/login/')); ?>" class="reg-btn" style="display:block;text-decoration:none;text-align:center;line-height:1;margin-top:8px">GO TO LOGIN →</a>
        <div style="margin-top:16px"><a href="<?php echo esc_url(home_url('/')); ?>" style="color:rgba(255,255,255,.3);font-size:12px;text-decoration:none">Back to home</a></div>
      </div>
    </div>

  </div>
</div>

<script>
/* ── Already logged in? ── */
(function(){
  try{var s=JSON.parse(localStorage.getItem('fw_session')||'null');if(s&&s.access_token&&s.expires_at>Date.now())window.location.href='<?php echo esc_js(home_url('/dashboard/')); ?>';}catch(e){}
})();

var _sb=null;

/* ── Country data (dial codes + names) ── */
var COUNTRIES=[
  {name:'India',code:'IN',dial:'+91'},
  {name:'Afghanistan',code:'AF',dial:'+93'},
  {name:'Albania',code:'AL',dial:'+355'},
  {name:'Algeria',code:'DZ',dial:'+213'},
  {name:'Argentina',code:'AR',dial:'+54'},
  {name:'Australia',code:'AU',dial:'+61'},
  {name:'Austria',code:'AT',dial:'+43'},
  {name:'Bangladesh',code:'BD',dial:'+880'},
  {name:'Belgium',code:'BE',dial:'+32'},
  {name:'Bhutan',code:'BT',dial:'+975'},
  {name:'Brazil',code:'BR',dial:'+55'},
  {name:'Canada',code:'CA',dial:'+1'},
  {name:'China',code:'CN',dial:'+86'},
  {name:'Denmark',code:'DK',dial:'+45'},
  {name:'Egypt',code:'EG',dial:'+20'},
  {name:'Finland',code:'FI',dial:'+358'},
  {name:'France',code:'FR',dial:'+33'},
  {name:'Germany',code:'DE',dial:'+49'},
  {name:'Greece',code:'GR',dial:'+30'},
  {name:'Hong Kong',code:'HK',dial:'+852'},
  {name:'Hungary',code:'HU',dial:'+36'},
  {name:'Indonesia',code:'ID',dial:'+62'},
  {name:'Iran',code:'IR',dial:'+98'},
  {name:'Iraq',code:'IQ',dial:'+964'},
  {name:'Ireland',code:'IE',dial:'+353'},
  {name:'Israel',code:'IL',dial:'+972'},
  {name:'Italy',code:'IT',dial:'+39'},
  {name:'Japan',code:'JP',dial:'+81'},
  {name:'Jordan',code:'JO',dial:'+962'},
  {name:'Kenya',code:'KE',dial:'+254'},
  {name:'Kuwait',code:'KW',dial:'+965'},
  {name:'Malaysia',code:'MY',dial:'+60'},
  {name:'Maldives',code:'MV',dial:'+960'},
  {name:'Mexico',code:'MX',dial:'+52'},
  {name:'Myanmar',code:'MM',dial:'+95'},
  {name:'Nepal',code:'NP',dial:'+977'},
  {name:'Netherlands',code:'NL',dial:'+31'},
  {name:'New Zealand',code:'NZ',dial:'+64'},
  {name:'Nigeria',code:'NG',dial:'+234'},
  {name:'Norway',code:'NO',dial:'+47'},
  {name:'Oman',code:'OM',dial:'+968'},
  {name:'Pakistan',code:'PK',dial:'+92'},
  {name:'Philippines',code:'PH',dial:'+63'},
  {name:'Poland',code:'PL',dial:'+48'},
  {name:'Portugal',code:'PT',dial:'+351'},
  {name:'Qatar',code:'QA',dial:'+974'},
  {name:'Russia',code:'RU',dial:'+7'},
  {name:'Saudi Arabia',code:'SA',dial:'+966'},
  {name:'Singapore',code:'SG',dial:'+65'},
  {name:'South Africa',code:'ZA',dial:'+27'},
  {name:'South Korea',code:'KR',dial:'+82'},
  {name:'Spain',code:'ES',dial:'+34'},
  {name:'Sri Lanka',code:'LK',dial:'+94'},
  {name:'Sweden',code:'SE',dial:'+46'},
  {name:'Switzerland',code:'CH',dial:'+41'},
  {name:'Taiwan',code:'TW',dial:'+886'},
  {name:'Thailand',code:'TH',dial:'+66'},
  {name:'Turkey',code:'TR',dial:'+90'},
  {name:'UAE',code:'AE',dial:'+971'},
  {name:'Uganda',code:'UG',dial:'+256'},
  {name:'Ukraine',code:'UA',dial:'+380'},
  {name:'United Kingdom',code:'GB',dial:'+44'},
  {name:'United States',code:'US',dial:'+1'},
  {name:'Vietnam',code:'VN',dial:'+84'},
];

/* ── Populate country code dropdown ── */
function buildCountryCodeSelect(){
  var sel=document.getElementById('regCountryCode');
  COUNTRIES.forEach(function(c){
    var opt=document.createElement('option');
    opt.value=c.dial;
    opt.dataset.code=c.code;
    opt.dataset.name=c.name;
    opt.textContent=c.code+' '+c.dial;
    if(c.code==='IN') opt.selected=true;
    sel.appendChild(opt);
  });
  /* Set country input to India by default */
  document.getElementById('regCountryInput').value='India';
  document.getElementById('regCountry').value='India';
}

function onCountryCodeChange(){
  var sel=document.getElementById('regCountryCode');
  var opt=sel.options[sel.selectedIndex];
  var name=opt.dataset.name;
  document.getElementById('regCountryInput').value=name;
  document.getElementById('regCountry').value=name;
  /* Clear state/city when country changes */
  document.getElementById('regStateInput').value='';
  document.getElementById('regState').value='';
  document.getElementById('regCityInput').value='';
  document.getElementById('regCity').value='';
}

/* ── Autocomplete ── */
var _acTimers={};
var _acCache={};

function acSearch(type,query){
  clearTimeout(_acTimers[type]);
  var listEl=document.getElementById('acList'+type.charAt(0).toUpperCase()+type.slice(1));
  if(!query||query.length<2){listEl.classList.remove('open');return;}
  _acTimers[type]=setTimeout(function(){_acFetch(type,query,listEl);},300);
}

function acKeyNav(type,e){
  var listEl=document.getElementById('acList'+type.charAt(0).toUpperCase()+type.slice(1));
  var items=listEl.querySelectorAll('.ac-item');
  if(!items.length||!listEl.classList.contains('open')) return;
  var cur=listEl.querySelector('.ac-item.active');
  var idx=-1;
  items.forEach(function(it,i){if(it===cur)idx=i;});
  if(e.key==='ArrowDown'){e.preventDefault();idx=Math.min(idx+1,items.length-1);}
  else if(e.key==='ArrowUp'){e.preventDefault();idx=Math.max(idx-1,0);}
  else if(e.key==='Enter'&&cur){e.preventDefault();cur.click();return;}
  else if(e.key==='Escape'){listEl.classList.remove('open');return;}
  else return;
  items.forEach(function(it){it.classList.remove('active');});
  if(items[idx]){items[idx].classList.add('active');items[idx].scrollIntoView({block:'nearest'});}
}

var WORLD_DATA={"Afghanistan": {"states": ["Kabul", "Kandahar", "Herat", "Balkh", "Nangarhar", "Kunduz", "Ghazni", "Badakhshan", "Takhar", "Baghlan"], "cities": ["Kabul", "Kandahar", "Herat", "Mazar-i-Sharif", "Jalalabad", "Kunduz", "Ghazni", "Lashkar Gah", "Taloqan", "Pul-e-Khumri"]}, "Australia": {"states": ["New South Wales", "Victoria", "Queensland", "Western Australia", "South Australia", "Tasmania", "Australian Capital Territory", "Northern Territory"], "cities": ["Sydney", "Melbourne", "Brisbane", "Perth", "Adelaide", "Hobart", "Canberra", "Darwin", "Gold Coast", "Newcastle"]}, "Bangladesh": {"states": ["Dhaka", "Chittagong", "Rajshahi", "Khulna", "Barisal", "Sylhet", "Rangpur", "Mymensingh"], "cities": ["Dhaka", "Chittagong", "Khulna", "Rajshahi", "Sylhet", "Barisal", "Rangpur", "Comilla", "Narayanganj", "Gazipur"]}, "Bhutan": {"states": ["Thimphu", "Paro", "Punakha", "Wangdue Phodrang", "Bumthang", "Trongsa", "Sarpang", "Chukha", "Samtse", "Haa"], "cities": ["Thimphu", "Paro", "Punakha", "Wangdue Phodrang", "Bumthang", "Trongsa", "Gelephu", "Phuntsholing", "Samdrup Jongkhar"]}, "Brazil": {"states": ["Sao Paulo", "Rio de Janeiro", "Minas Gerais", "Bahia", "Parana", "Rio Grande do Sul", "Pernambuco", "Ceara", "Para", "Amazonas"], "cities": ["Sao Paulo", "Rio de Janeiro", "Brasilia", "Salvador", "Fortaleza", "Belo Horizonte", "Manaus", "Curitiba", "Recife", "Porto Alegre"]}, "Canada": {"states": ["Ontario", "Quebec", "British Columbia", "Alberta", "Manitoba", "Saskatchewan", "Nova Scotia", "New Brunswick", "Newfoundland", "Prince Edward Island"], "cities": ["Toronto", "Montreal", "Vancouver", "Calgary", "Edmonton", "Ottawa", "Winnipeg", "Quebec City", "Hamilton", "Kitchener"]}, "China": {"states": ["Beijing", "Shanghai", "Guangdong", "Sichuan", "Zhejiang", "Jiangsu", "Shandong", "Henan", "Hubei", "Hunan"], "cities": ["Beijing", "Shanghai", "Guangzhou", "Shenzhen", "Chengdu", "Hangzhou", "Wuhan", "Xian", "Nanjing", "Tianjin"]}, "France": {"states": ["Ile-de-France", "Provence-Alpes-Cote dAzur", "Auvergne-Rhone-Alpes", "Occitanie", "Nouvelle-Aquitaine", "Hauts-de-France", "Grand Est", "Pays de la Loire", "Bretagne", "Normandie"], "cities": ["Paris", "Marseille", "Lyon", "Toulouse", "Nice", "Nantes", "Montpellier", "Strasbourg", "Bordeaux", "Lille"]}, "Germany": {"states": ["Bavaria", "North Rhine-Westphalia", "Baden-Wurttemberg", "Lower Saxony", "Hesse", "Saxony", "Rhineland-Palatinate", "Berlin", "Schleswig-Holstein", "Brandenburg"], "cities": ["Berlin", "Hamburg", "Munich", "Cologne", "Frankfurt", "Stuttgart", "Dusseldorf", "Dortmund", "Essen", "Leipzig"]}, "Indonesia": {"states": ["Java", "Sumatra", "Kalimantan", "Sulawesi", "Papua", "Bali", "Nusa Tenggara", "Maluku"], "cities": ["Jakarta", "Surabaya", "Bandung", "Medan", "Semarang", "Makassar", "Palembang", "Tangerang", "Depok", "Denpasar"]}, "Iran": {"states": ["Tehran", "Isfahan", "Fars", "Khorasan", "Khuzestan", "East Azerbaijan", "Gilan", "Mazandaran", "Alborz", "Bushehr"], "cities": ["Tehran", "Mashhad", "Isfahan", "Karaj", "Tabriz", "Shiraz", "Ahvaz", "Qom", "Kermanshah", "Rasht"]}, "Italy": {"states": ["Lombardy", "Lazio", "Campania", "Sicily", "Veneto", "Piedmont", "Emilia-Romagna", "Apulia", "Tuscany", "Calabria"], "cities": ["Rome", "Milan", "Naples", "Turin", "Palermo", "Genoa", "Bologna", "Florence", "Bari", "Catania"]}, "Japan": {"states": ["Tokyo", "Osaka", "Kanagawa", "Aichi", "Saitama", "Chiba", "Hyogo", "Hokkaido", "Fukuoka", "Shizuoka"], "cities": ["Tokyo", "Yokohama", "Osaka", "Nagoya", "Sapporo", "Fukuoka", "Kobe", "Kawasaki", "Kyoto", "Saitama"]}, "Malaysia": {"states": ["Selangor", "Kuala Lumpur", "Johor", "Sabah", "Sarawak", "Penang", "Perak", "Kedah", "Kelantan", "Terengganu"], "cities": ["Kuala Lumpur", "George Town", "Ipoh", "Johor Bahru", "Kota Kinabalu", "Kuching", "Shah Alam", "Petaling Jaya", "Subang Jaya", "Miri"]}, "Maldives": {"states": ["Male", "Addu", "Fuvahmulah", "Kulhudhuffushi", "Thinadhoo"], "cities": ["Male", "Addu City", "Fuvahmulah", "Kulhudhuffushi", "Thinadhoo"]}, "Myanmar": {"states": ["Yangon", "Mandalay", "Sagaing", "Bago", "Magway", "Ayeyarwady", "Tanintharyi", "Shan", "Kachin", "Kayah"], "cities": ["Yangon", "Mandalay", "Naypyidaw", "Mawlamyine", "Bago", "Pathein", "Monywa", "Sittwe", "Taunggyi", "Meiktila"]}, "Pakistan": {"states": ["Punjab", "Sindh", "Khyber Pakhtunkhwa", "Balochistan", "Islamabad Capital Territory", "Gilgit-Baltistan", "Azad Kashmir"], "cities": ["Karachi", "Lahore", "Faisalabad", "Rawalpindi", "Islamabad", "Multan", "Gujranwala", "Peshawar", "Quetta", "Sialkot"]}, "Philippines": {"states": ["Metro Manila", "Cebu", "Davao", "Calabarzon", "Central Luzon", "Western Visayas", "Northern Mindanao", "Ilocos", "Cagayan Valley", "Cordillera"], "cities": ["Manila", "Quezon City", "Davao", "Caloocan", "Zamboanga", "Cebu", "Antipolo", "Pasig", "Taguig", "Cagayan de Oro"]}, "Russia": {"states": ["Moscow", "Saint Petersburg", "Novosibirsk", "Yekaterinburg", "Kazan", "Nizhny Novgorod", "Chelyabinsk", "Samara", "Ufa", "Rostov"], "cities": ["Moscow", "Saint Petersburg", "Novosibirsk", "Yekaterinburg", "Kazan", "Nizhny Novgorod", "Chelyabinsk", "Samara", "Ufa", "Rostov-on-Don"]}, "Saudi Arabia": {"states": ["Riyadh", "Makkah", "Madinah", "Eastern Province", "Asir", "Tabuk", "Hail", "Northern Borders", "Jizan", "Najran"], "cities": ["Riyadh", "Jeddah", "Mecca", "Medina", "Dammam", "Taif", "Tabuk", "Buraidah", "Khamis Mushait", "Khobar"]}, "Singapore": {"states": ["Central", "East", "North", "North-East", "West"], "cities": ["Singapore", "Jurong East", "Woodlands", "Tampines", "Sengkang", "Punggol", "Yishun", "Bukit Batok", "Hougang", "Choa Chu Kang"]}, "South Korea": {"states": ["Seoul", "Busan", "Incheon", "Daegu", "Daejeon", "Gwangju", "Suwon", "Ulsan", "Gyeonggi", "North Gyeongsang"], "cities": ["Seoul", "Busan", "Incheon", "Daegu", "Daejeon", "Gwangju", "Suwon", "Ulsan", "Changwon", "Seongnam"]}, "Spain": {"states": ["Andalusia", "Catalonia", "Madrid", "Valencia", "Galicia", "Castile and Leon", "Basque Country", "Castilla-La Mancha", "Canary Islands", "Murcia"], "cities": ["Madrid", "Barcelona", "Valencia", "Seville", "Zaragoza", "Malaga", "Murcia", "Palma", "Las Palmas", "Bilbao"]}, "Sri Lanka": {"states": ["Western", "Central", "Southern", "Northern", "Eastern", "North Western", "North Central", "Uva", "Sabaragamuwa"], "cities": ["Colombo", "Kandy", "Galle", "Jaffna", "Negombo", "Anuradhapura", "Trincomalee", "Batticaloa", "Ratnapura", "Matara"]}, "Thailand": {"states": ["Bangkok", "Chiang Mai", "Phuket", "Chonburi", "Nakhon Ratchasima", "Udon Thani", "Khon Kaen", "Chiang Rai", "Surat Thani", "Lampang"], "cities": ["Bangkok", "Chiang Mai", "Phuket", "Pattaya", "Hat Yai", "Nakhon Ratchasima", "Udon Thani", "Khon Kaen", "Surat Thani", "Chiang Rai"]}, "Turkey": {"states": ["Istanbul", "Ankara", "Izmir", "Bursa", "Antalya", "Adana", "Konya", "Gaziantep", "Sanliurfa", "Kocaeli"], "cities": ["Istanbul", "Ankara", "Izmir", "Bursa", "Antalya", "Adana", "Konya", "Gaziantep", "Sanliurfa", "Kocaeli"]}, "UAE": {"states": ["Dubai", "Abu Dhabi", "Sharjah", "Ajman", "Fujairah", "Ras Al Khaimah", "Umm Al Quwain"], "cities": ["Dubai", "Abu Dhabi", "Sharjah", "Al Ain", "Ajman", "Ras Al Khaimah", "Fujairah", "Umm Al Quwain", "Khor Fakkan", "Dibba Al Hisn"]}, "United Kingdom": {"states": ["England", "Scotland", "Wales", "Northern Ireland"], "cities": ["London", "Birmingham", "Manchester", "Glasgow", "Liverpool", "Leeds", "Sheffield", "Edinburgh", "Bristol", "Leicester"]}, "United States": {"states": ["California", "Texas", "Florida", "New York", "Pennsylvania", "Illinois", "Ohio", "Georgia", "North Carolina", "Michigan"], "cities": ["New York", "Los Angeles", "Chicago", "Houston", "Phoenix", "Philadelphia", "San Antonio", "San Diego", "Dallas", "San Jose"]}, "Vietnam": {"states": ["Ho Chi Minh City", "Hanoi", "Da Nang", "Haiphong", "Can Tho", "Bien Hoa", "Hue", "Nha Trang", "Da Lat", "Vung Tau"], "cities": ["Ho Chi Minh City", "Hanoi", "Da Nang", "Haiphong", "Can Tho", "Bien Hoa", "Hue", "Nha Trang", "Da Lat", "Vung Tau"]}};

/* ── India states + major cities (bundled) ── */
var IN_STATES=['Andaman and Nicobar Islands','Andhra Pradesh','Arunachal Pradesh','Assam','Bihar','Chandigarh','Chhattisgarh','Dadra and Nagar Haveli and Daman and Diu','Delhi','Goa','Gujarat','Haryana','Himachal Pradesh','Jammu and Kashmir','Jharkhand','Karnataka','Kerala','Ladakh','Lakshadweep','Madhya Pradesh','Maharashtra','Manipur','Meghalaya','Mizoram','Nagaland','Odisha','Puducherry','Punjab','Rajasthan','Sikkim','Tamil Nadu','Telangana','Tripura','Uttar Pradesh','Uttarakhand','West Bengal'];
var IN_CITIES={
  'Uttarakhand':['Dehradun','Haridwar','Rishikesh','Nainital','Mussoorie','Haldwani','Roorkee','Kashipur','Rudrapur','Kotdwar','Ramnagar','Almora','Pithoragarh','Bageshwar','Champawat','Pauri','Tehri','Uttarkashi','Chamoli','Rudraprayag'],
  'Delhi':['New Delhi','Delhi','Dwarka','Rohini','Janakpuri','Laxmi Nagar','Saket','Vasant Kunj','Karol Bagh','Connaught Place'],
  'Maharashtra':['Mumbai','Pune','Nagpur','Nashik','Aurangabad','Solapur','Kolhapur','Amravati','Navi Mumbai','Thane'],
  'Karnataka':['Bangalore','Mysore','Hubli','Mangalore','Belgaum','Gulbarga','Davangere','Bellary','Bijapur','Shimoga'],
  'Tamil Nadu':['Chennai','Coimbatore','Madurai','Tiruchirappalli','Salem','Tirunelveli','Erode','Vellore','Thoothukudi','Dindigul'],
  'Gujarat':['Ahmedabad','Surat','Vadodara','Rajkot','Bhavnagar','Jamnagar','Gandhinagar','Junagadh','Anand','Bharuch'],
  'Rajasthan':['Jaipur','Jodhpur','Udaipur','Kota','Bikaner','Ajmer','Bharatpur','Alwar','Bhilwara','Sikar'],
  'Uttar Pradesh':['Lucknow','Kanpur','Varanasi','Agra','Meerut','Allahabad','Ghaziabad','Noida','Bareilly','Aligarh'],
  'West Bengal':['Kolkata','Howrah','Durgapur','Asansol','Siliguri','Bardhaman','Malda','Baharampur','Habra','Kharagpur'],
  'Himachal Pradesh':['Shimla','Manali','Dharamshala','Kullu','Mandi','Solan','Una','Hamirpur','Bilaspur','Chamba'],
  'Punjab':['Chandigarh','Ludhiana','Amritsar','Jalandhar','Patiala','Bathinda','Mohali','Firozpur','Hoshiarpur','Gurdaspur'],
  'Haryana':['Gurugram','Faridabad','Panipat','Ambala','Hisar','Rohtak','Karnal','Sonipat','Yamunanagar','Bhiwani'],
  'Madhya Pradesh':['Bhopal','Indore','Jabalpur','Gwalior','Ujjain','Sagar','Dewas','Satna','Ratlam','Rewa'],
  'Bihar':['Patna','Gaya','Bhagalpur','Muzaffarpur','Darbhanga','Arrah','Begusarai','Katihar','Munger','Chhapra'],
  'Assam':['Guwahati','Silchar','Dibrugarh','Jorhat','Nagaon','Tinsukia','Tezpur','Bongaigaon','Dhubri','Lakhimpur'],
  'Kerala':['Thiruvananthapuram','Kochi','Kozhikode','Thrissur','Kollam','Palakkad','Alappuzha','Kannur','Kasaragod','Kottayam'],
  'Andhra Pradesh':['Visakhapatnam','Vijayawada','Guntur','Nellore','Kurnool','Rajahmundry','Tirupati','Kadapa','Kakinada','Anantapur'],
  'Telangana':['Hyderabad','Warangal','Nizamabad','Karimnagar','Khammam','Ramagundam','Mahbubnagar','Nalgonda','Adilabad','Suryapet'],
  'Odisha':['Bhubaneswar','Cuttack','Rourkela','Berhampur','Sambalpur','Puri','Balasore','Bhadrak','Baripada','Jharsuguda'],
  'Goa':['Panaji','Margao','Vasco da Gama','Mapusa','Ponda','Bicholim','Curchorem','Sanquelim'],
  'Jharkhand':['Ranchi','Jamshedpur','Dhanbad','Bokaro','Deoghar','Phusro','Hazaribagh','Giridih','Ramgarh','Medininagar'],
  'Chhattisgarh':['Raipur','Bhilai','Korba','Bilaspur','Durg','Rajnandgaon','Jagdalpur','Raigarh','Ambikapur','Chirmiri'],
  'Jammu and Kashmir':['Srinagar','Jammu','Anantnag','Sopore','Baramulla','Kathua','Udhampur','Punch','Rajouri','Kupwara'],
  'Ladakh':['Leh','Kargil'],
  'Arunachal Pradesh':['Itanagar','Naharlagun','Pasighat','Tezpur','Bomdila','Ziro','Along','Tezu'],
  'Manipur':['Imphal','Thoubal','Bishnupur','Churachandpur','Senapati'],
  'Meghalaya':['Shillong','Tura','Nongstoin','Jowai','Baghmara'],
  'Mizoram':['Aizawl','Lunglei','Saiha','Champhai','Kolasib'],
  'Nagaland':['Kohima','Dimapur','Mokokchung','Tuensang','Wokha'],
  'Sikkim':['Gangtok','Namchi','Mangan','Gyalshing'],
  'Tripura':['Agartala','Udaipur','Dharmanagar','Kailasahar','Belonia'],
};

/* Nepal states */
var NP_STATES=['Koshi','Madhesh','Bagmati','Gandaki','Lumbini','Karnali','Sudurpashchim'];
var NP_CITIES={'Bagmati':['Kathmandu','Lalitpur','Bhaktapur','Kirtipur','Hetauda'],'Koshi':['Biratnagar','Dharan','Itahari','Damak','Birtamod'],'Gandaki':['Pokhara','Baglung','Gorkha','Syangja'],'Lumbini':['Butwal','Bhairahawa','Tansen','Nepalgunj'],'Madhesh':['Birgunj','Janakpur','Rajbiraj','Lahan'],'Karnali':['Surkhet','Jumla','Dailekh'],'Sudurpashchim':['Dhangadhi','Mahendranagar','Dadeldhura']};

function _acFetch(type,query,listEl){
  var country=document.getElementById('regCountry').value||'India';
  var state=document.getElementById('regState').value||'';
  var cacheKey=type+':'+country+':'+state+':'+query;
  if(_acCache[cacheKey]){_acRender(type,_acCache[cacheKey],listEl);return;}

  listEl.innerHTML='<div class="ac-loading">Searching…</div>';
  listEl.classList.add('open');

  if(type==='country'){
    var results=COUNTRIES.filter(function(c){return c.name.toLowerCase().includes(query.toLowerCase());}).map(function(c){return c.name;});
    _acCache[cacheKey]=results;
    _acRender(type,results,listEl);
    return;
  }

  /* Use bundled data for India and Nepal */
  if(type==='state'){
    var stateList=country==='India'?IN_STATES:country==='Nepal'?NP_STATES:null;
    if(stateList){
      var results=stateList.filter(function(s){return s.toLowerCase().includes(query.toLowerCase());});
      _acCache[cacheKey]=results;
      _acRender(type,results,listEl);
      return;
    }
    /* Other countries: check WORLD_DATA */
    var wdS=WORLD_DATA[country];
    if(wdS&&wdS.states){
      var results=wdS.states.filter(function(s){return s.toLowerCase().includes(query.toLowerCase());});
      _acCache[cacheKey]=results;
      _acRender(type,results,listEl);
      return;
    }
    listEl.innerHTML='<div class="ac-loading">Type your state/province name.</div>';
    document.getElementById('regState').value=query;
    document.getElementById('regStateInput').value=query;
    return;
  }

  if(type==='city'){
    var cityMap=country==='India'?IN_CITIES:country==='Nepal'?NP_CITIES:null;
    if(cityMap){
      var pool=state&&cityMap[state]?cityMap[state]:Object.values(cityMap).reduce(function(a,b){return a.concat(b);},[]);
      var results=pool.filter(function(c){return c.toLowerCase().includes(query.toLowerCase());}).slice(0,20);
      _acCache[cacheKey]=results;
      _acRender(type,results,listEl);
      return;
    }
    /* Other countries: check WORLD_DATA */
    var wdC=WORLD_DATA[country];
    if(wdC&&wdC.cities){
      var results=wdC.cities.filter(function(c){return c.toLowerCase().includes(query.toLowerCase());}).slice(0,20);
      _acCache[cacheKey]=results;
      _acRender(type,results,listEl);
      return;
    }
    listEl.innerHTML='<div class="ac-loading">Type your city name.</div>';
    document.getElementById('regCity').value=query;
    document.getElementById('regCityInput').value=query;
    return;
  }
}

function _acRender(type,results,listEl){
  if(!results.length){listEl.innerHTML='<div class="ac-loading">No results found.</div>';listEl.classList.add('open');return;}
  listEl.innerHTML=results.slice(0,20).map(function(r){
    return '<div class="ac-item" onclick="acSelect(\''+type+'\',\''+r.replace(/'/g,"\\'")+'\')">' + r + '</div>';
  }).join('');
  listEl.classList.add('open');
}

function acSelect(type,value){
  var listEl=document.getElementById('acList'+type.charAt(0).toUpperCase()+type.slice(1));
  listEl.classList.remove('open');
  if(type==='country'){
    document.getElementById('regCountryInput').value=value;
    document.getElementById('regCountry').value=value;
    /* Sync country code dropdown */
    var sel=document.getElementById('regCountryCode');
    for(var i=0;i<sel.options.length;i++){
      if(sel.options[i].dataset.name===value){sel.selectedIndex=i;break;}
    }
    document.getElementById('regStateInput').value='';
    document.getElementById('regState').value='';
    document.getElementById('regCityInput').value='';
    document.getElementById('regCity').value='';
  } else if(type==='state'){
    document.getElementById('regStateInput').value=value;
    document.getElementById('regState').value=value;
    document.getElementById('regCityInput').value='';
    document.getElementById('regCity').value='';
  } else if(type==='city'){
    document.getElementById('regCityInput').value=value;
    document.getElementById('regCity').value=value;
  }
}

/* Close dropdowns on outside click */
document.addEventListener('click',function(e){
  if(!e.target.closest('.ac-wrap')){
    document.querySelectorAll('.ac-list').forEach(function(l){l.classList.remove('open');});
  }
});

/* ── Password helpers ── */
function togglePw(id,btn){
  var el=document.getElementById(id);if(!el)return;
  el.type=el.type==='password'?'text':'password';
  btn.textContent=el.type==='password'?'👁':'🙈';
}

function updatePwStrength(pw){
  var bar=document.getElementById('pwBar');if(!bar)return;
  var score=0;
  if(pw.length>=8)score++;if(/[A-Z]/.test(pw))score++;if(/[0-9]/.test(pw))score++;if(/[^A-Za-z0-9]/.test(pw))score++;
  var colors=['#f87171','#fb923c','#facc15','#4ade80'];
  bar.style.width=(score*25)+'%';bar.style.background=colors[score-1]||'transparent';
}

/* ── Init ── */
document.addEventListener('DOMContentLoaded',function(){
  if(window.supabase&&window.FW_AUTH) _sb=supabase.createClient(FW_AUTH.supabase_url,FW_AUTH.supabase_key);
  buildCountryCodeSelect();
  document.getElementById('regPassword').addEventListener('input',function(){updatePwStrength(this.value);});
  ['regFirstName','regLastName','regEmail','regPhone'].forEach(function(id){
    var el=document.getElementById(id);
    if(el) el.addEventListener('keydown',function(e){if(e.key==='Enter')regSubmitDetails();});
  });
});

/* ── Submit ── */
async function regSubmitDetails(){
  var btn=document.getElementById('regBtn1');
  var msg=document.getElementById('regMsg1');
  msg.textContent='';msg.className='reg-msg';

  var firstName=document.getElementById('regFirstName').value.trim();
  var lastName=document.getElementById('regLastName').value.trim();
  var email=document.getElementById('regEmail').value.trim().toLowerCase();
  var password=document.getElementById('regPassword').value;
  var password2=document.getElementById('regPassword2').value;
  var dialCode=document.getElementById('regCountryCode').value;
  var phoneRaw=document.getElementById('regPhone').value.trim();
  var phone=phoneRaw?(dialCode+phoneRaw):'';
  var city=document.getElementById('regCity').value.trim();
  var state=document.getElementById('regState').value.trim();
  var country=document.getElementById('regCountry').value.trim();

  if(!firstName){showMsg('regMsg1','First name is required.','error');document.getElementById('regFirstName').focus();return;}
  if(!email||!email.includes('@')||!email.includes('.')){showMsg('regMsg1','Please enter a valid email address.','error');document.getElementById('regEmail').focus();return;}
  if(!password||password.length<8){showMsg('regMsg1','Password must be at least 8 characters.','error');document.getElementById('regPassword').focus();return;}
  if(password!==password2){showMsg('regMsg1','Passwords do not match.','error');document.getElementById('regPassword2').focus();return;}
  if(!_sb){showMsg('regMsg1','Connection error. Please refresh and try again.','error');return;}

  btn.disabled=true;btn.textContent='Creating account…';

  try{
    var result=await _sb.auth.signUp({
      email:email,password:password,
      options:{
        data:{first_name:firstName,last_name:lastName,phone:phone,city:city,state:state,country:country},
        emailRedirectTo:'<?php echo esc_js(home_url('/login/')); ?>'
      }
    });
    if(result.error) throw result.error;

    if(result.data.session){
      var session=result.data.session;
      localStorage.setItem('fw_session',JSON.stringify({
        access_token:session.access_token,refresh_token:session.refresh_token,
        user_id:session.user.id,email:session.user.email,first_name:firstName,
        expires_at:Date.now()+(session.expires_in*1000)
      }));
      await fetch(FW_AUTH.rest_url+'/fw-register',{
        method:'POST',headers:{'Content-Type':'application/json','Authorization':'Bearer '+session.access_token},
        body:JSON.stringify({first_name:firstName,last_name:lastName,phone:phone,city:city,state:state,country:country})
      });
      window.location.href='<?php echo esc_js(home_url('/dashboard/')); ?>';
      return;
    }

    document.getElementById('regVerifyMsg').textContent='We sent a confirmation link to '+email+'. Click it to activate your account, then log in with your password.';
    showStep(2);

  }catch(err){
    var errMsg=err.message||'Registration failed. Please try again.';
    if(errMsg.toLowerCase().includes('already registered')||errMsg.toLowerCase().includes('already exists')){
      msg.innerHTML='An account with this email already exists. <a href="<?php echo esc_js(home_url('/login/')); ?>" style="color:var(--rust)">Log in instead</a>';
      msg.className='reg-msg error';return;
    }
    showMsg('regMsg1',errMsg,'error');
  }finally{
    btn.disabled=false;btn.textContent='CREATE ACCOUNT →';
  }
}

function showStep(n){
  document.getElementById('regStep1').classList.remove('active');
  document.getElementById('regStep2').classList.remove('active');
  document.getElementById('regStep'+n).classList.add('active');
}
function showMsg(id,text,type){var el=document.getElementById(id);el.textContent=text;el.className='reg-msg '+type;}
</script>

<?php get_footer(); ?>
