<?php
session_start();

if(!isset($_SESSION['id']) || $_SESSION['role']!=='parent'){
    header("Location: /Babysafe/auth/login.php");
    exit;
}

$id = $_SESSION['id'];
$page='Verification';
require('../../../includes/parent_panel.php');

$errors = [];

if($_SERVER['REQUEST_METHOD'] == 'POST'){

    $_SESSION['address'] = [
        'p_province' => $_POST['p_province'] ?? '',
        'p_district' => $_POST['p_district'] ?? '',
        'p_city'     => $_POST['p_city'] ?? '',
        'p_ward'     => $_POST['p_ward'] ?? '',
        'p_tole'     => $_POST['p_tole'] ?? '',
        't_province' => $_POST['t_province'] ?? '',
        't_district' => $_POST['t_district'] ?? '',
        't_city'     => $_POST['t_city'] ?? '',
        't_ward'     => $_POST['t_ward'] ?? '',
        't_tole'     => $_POST['t_tole'] ?? ''
    ];

    header("Location: document.php"); // change later
    exit();
}

$address = $_SESSION['address'] ?? [];
?>

<h2>Address Information</h2>

<form method="POST">

    <h3>Permanent Address</h3>

    <!-- Province + District -->
    <div class="input-row">
        <div class="input-field small">
            <label>Province <span class="required">*</span></label>
            <select name="p_province" required>
                <option value="">Select Province</option>
                <option value="koshi">Koshi</option>
                <option value="madhesh">Madhesh</option>
                <option value="bagmati">Bagmati</option>
                <option value="gandaki">Gandaki</option>
                <option value="lumbini">Lumbini</option>
                <option value="karnali">Karnali</option>
                <option value="sudurpashchim">Sudurpashchim</option>
            </select>
        </div>

        <div class="input-field small">
            <label>District <span class="required">*</span></label>
            <select name="p_district" required>
                <option value="">Select District</option>
            </select>
        </div>
    </div>

    <!-- City + Ward + Tole -->
    <div class="input-row">
        <div class="input-field small">
            <label>City <span class="required">*</span></label>
            <input type="text" name="p_city" required>
        </div>
        <div class="input-field small">
            <label>Ward No <span class="required">*</span></label>
            <input type="number" name="p_ward" required>
        </div>
        <div class="input-field small">
            <label>Tole <span class="required">*</span></label>
            <input type="text" name="p_tole" required>
        </div>
    </div>

    <div class="checkbox-field">
        <label>
            <input type="checkbox" id="sameAddress">
            Temporary Address same as Permanent
        </label>
    </div>

    <h3>Temporary Address</h3>

    <!-- Province + District -->
    <div class="input-row">
        <div class="input-field small">
            <label>Province</label>
            <select name="t_province">
                <option value="">Select Province</option>
                <option value="koshi">Koshi</option>
                <option value="madhesh">Madhesh</option>
                <option value="bagmati">Bagmati</option>
                <option value="gandaki">Gandaki</option>
                <option value="lumbini">Lumbini</option>
                <option value="karnali">Karnali</option>
                <option value="sudurpashchim">Sudurpashchim</option>
            </select>
        </div>

        <div class="input-field small">
            <label>District</label>
            <select name="t_district">
                <option value="">Select District</option>
            </select>
        </div>
    </div>

    <!-- City + Ward + Tole -->
    <div class="input-row">
        <div class="input-field small">
            <label>City</label>
            <input type="text" name="t_city">
        </div>
        <div class="input-field small">
            <label>Ward No</label>
            <input type="number" name="t_ward">
        </div>
        <div class="input-field small">
            <label>Tole</label>
            <input type="text" name="t_tole">
        </div>
    </div>

    <br>
    <button type="submit">Next</button>

</form>

<script>
const districts = {
    koshi:["Bhojpur","Dhankuta","Ilam","Jhapa","Morang","Sunsari"],
    madhesh:["Bara","Dhanusha","Parsa","Rautahat","Saptari"],
    bagmati:["Kathmandu","Bhaktapur","Lalitpur","Chitwan"],
    gandaki:["Kaski","Lamjung","Tanahun","Gorkha"],
    lumbini:["Rupandehi","Dang","Banke","Kapilvastu"],
    karnali:["Surkhet","Jumla","Dolpa","Humla"],
    sudurpashchim:["Kailali","Kanchanpur","Doti","Bajura"]
};

function loadDistrict(provinceName,districtName){
    let province = document.querySelector(`select[name="${provinceName}"]`).value;
    let districtSelect = document.querySelector(`select[name="${districtName}"]`);
    districtSelect.innerHTML = '<option value="">Select District</option>';

    if(districts[province]){
        districts[province].forEach(d=>{
            let opt=document.createElement("option");
            opt.value=d;
            opt.textContent=d;
            districtSelect.appendChild(opt);
        });
    }
}

document.querySelector('select[name="p_province"]').addEventListener("change",function(){
    loadDistrict("p_province","p_district");
});

document.querySelector('select[name="t_province"]').addEventListener("change",function(){
    loadDistrict("t_province","t_district");
});

document.getElementById("sameAddress").addEventListener("change",function(){
    if(this.checked){
        document.querySelector('[name="t_province"]').value =
        document.querySelector('[name="p_province"]').value;

        loadDistrict("p_province","t_district");

        document.querySelector('[name="t_district"]').value =
        document.querySelector('[name="p_district"]').value;

        document.querySelector('[name="t_city"]').value =
        document.querySelector('[name="p_city"]').value;

        document.querySelector('[name="t_ward"]').value =
        document.querySelector('[name="p_ward"]').value;

        document.querySelector('[name="t_tole"]').value =
        document.querySelector('[name="p_tole"]').value;
    }
});
</script>
</body>
</html>