<script type="application/javascript" src="https://cdn.jsdelivr.net/npm/vue@2.6.12/dist/vue.js"></script>
<script type="application/javascript" src="https://cdn.jsdelivr.net/npm/axios/dist/axios.min.js"></script>

<script type="application/javascript">
    const app = new Vue({
        el: '#appWrapper',
        data: {
            year: '',
            vehicleType: '',
            vehicleMake: '',
            vehicleMakeModel: '',
            otherVehicleMake: '',
            otherVehicleMakeModel: '',
            insuranceType: '',
            roadWorthiness: '',
            hackneyPermit: '',
            vehicleLicense: '',
            vehicleValue: '',
            preferredInsurer: '',
            plan: '',
            numberPlateType: '',
            vehicleLicenseExpiry: '',
            registrationType: '',
            permits: '',
            vehicleRegAgreement: false,
            vehicleMakeModels: [],
            finishedFetchingModels: false,
            stillFetchingModels: false,

            yearNewVehicle: '',
            vehicleTypeNewVehicle: '',
            vehicleMakeNewVehicle: '',
            vehicleMakeModelNewVehicle: '',
            otherVehicleMakeNewVehicle: '',
            otherVehicleMakeModelNewVehicle: '',
            insuranceTypeNewVehicle: '',
            vehicleValueNewVehicle: '',
            preferredInsurerNewVehicle: '',
            planNewVehicle: '',
            numberPlateTypeNewVehicle: '',
            vehicleMakeModelsNewVehicle: [],
            finishedFetchingModelsNewVehicle: false,
            stillFetchingModelsNewVehicle: false,

            yearOwnership: '',
            vehicleTypeOwnership: '',
            vehicleMakeOwnership: '',
            vehicleMakeModelOwnership: '',
            otherVehicleMakeOwnership: '',
            otherVehicleMakeModelOwnership: '',
            vehicleLicenseExpiryOwnership: '',
            registrationTypeOwnership: '',
            numberPlateTypeOwnership: '',
            vehicleMakeModelsOwnership: [],
            finishedFetchingModelsOwnership: false,
            stillFetchingModelsOwnership: false,

            permitsOtherVehicle: [],

            setFromURL: false,
        },
        methods: {
            async fetchModel () {
                // if(this.vehicleMake == "" || this.year == ""){
                //     return;
                // }
                if(this.vehicleMake == ""){
                    return;
                }
                this.finishedFetchingModels = false;
                this.stillFetchingModels = true;
                this.vehicleMakeModels = [];

                if(!this.setFromURL){
                    this.vehicleMakeModel = "";
                    this.year = "";
                }else{
                    this.setFromURL = false;
                }

                

                // var year = parseInt(this.year)
                const where = encodeURIComponent(JSON.stringify({
                    "Make": this.vehicleMake,
                    // "Year": year
                }));
                const response = await fetch(
                    `https://parseapi.back4app.com/classes/Car_Model_List?count=1&limit=1000&order=Year&where=${where}`,
                    {
                        headers: {
                        'X-Parse-Application-Id': 'hlhoNKjOvEhqzcVAJ1lxjicJLZNVv36GdbboZj3Z', // This is the fake app's application id
                        'X-Parse-Master-Key': 'SNMJJF0CZZhTPhLDIqGhTlUNV9r60M2Z5spyWfXW', // This is the fake app's readonly master key
                        }
                    }
                );
                const data = await response.json(); // Here you have the data that you need

                this.finishedFetchingModels = true;
                this.stillFetchingModels = false;
                
                let results = data.results;
                results =  Object.values(results.reduce((acc,cur)=>Object.assign(acc,{[cur.Model]:cur}),{}))
                this.vehicleMakeModels = results;
                
                return data;
                // console.log(data.results);
                // console.log(JSON.stringify(data, null, 2));

            },
            async fetchModelNewVehicle () {
                // if(this.vehicleMake == "" || this.year == ""){
                //     return;
                // }
                if(this.vehicleMakeNewVehicle == ""){
                    return;
                }
                this.finishedFetchingModelsNewVehicle = false;
                this.stillFetchingModelsNewVehicle = true;
                this.vehicleMakeModelsNewVehicle = [];

                // var year = parseInt(this.year)
                const where = encodeURIComponent(JSON.stringify({
                    "Make": this.vehicleMakeNewVehicle,
                    // "Year": year
                }));
                const response = await fetch(
                    `https://parseapi.back4app.com/classes/Car_Model_List?count=1&limit=1000&order=Year&where=${where}`,
                    {
                        headers: {
                        'X-Parse-Application-Id': 'hlhoNKjOvEhqzcVAJ1lxjicJLZNVv36GdbboZj3Z', // This is the fake app's application id
                        'X-Parse-Master-Key': 'SNMJJF0CZZhTPhLDIqGhTlUNV9r60M2Z5spyWfXW', // This is the fake app's readonly master key
                        }
                    }
                );
                const data = await response.json(); // Here you have the data that you need

                this.finishedFetchingModelsNewVehicle = true;
                this.stillFetchingModelsNewVehicle = false;
                
                let results = data.results;
                results =  Object.values(results.reduce((acc,cur)=>Object.assign(acc,{[cur.Model]:cur}),{}))
                this.vehicleMakeModelsNewVehicle = results;
                
                return data;
                // console.log(data.results);
                // console.log(JSON.stringify(data, null, 2));

            },
            async fetchModelOwnership () {
                // if(this.vehicleMake == "" || this.year == ""){
                //     return;
                // }
                if(this.vehicleMakeOwnership == ""){
                    return;
                }
                this.finishedFetchingModelsOwnership = false;
                this.stillFetchingModelsOwnership = true;
                this.vehicleMakeModelsOwnership = [];

                // var year = parseInt(this.year)
                const where = encodeURIComponent(JSON.stringify({
                    "Make": this.vehicleMakeOwnership,
                    // "Year": year
                }));
                const response = await fetch(
                    `https://parseapi.back4app.com/classes/Car_Model_List?count=1&limit=1000&order=Year&where=${where}`,
                    {
                        headers: {
                        'X-Parse-Application-Id': 'hlhoNKjOvEhqzcVAJ1lxjicJLZNVv36GdbboZj3Z', // This is the fake app's application id
                        'X-Parse-Master-Key': 'SNMJJF0CZZhTPhLDIqGhTlUNV9r60M2Z5spyWfXW', // This is the fake app's readonly master key
                        }
                    }
                );
                const data = await response.json(); // Here you have the data that you need

                this.finishedFetchingModelsOwnership = true;
                this.stillFetchingModelsOwnership = false;
                
                let results = data.results;
                results =  Object.values(results.reduce((acc,cur)=>Object.assign(acc,{[cur.Model]:cur}),{}))
                this.vehicleMakeModelsOwnership = results;
                
                return data;
                // console.log(data.results);
                // console.log(JSON.stringify(data, null, 2));

            },
            goToParticulars(){
                window.open(`particulars?vt=${this.vehicleType}&vm=${this.vehicleMake}&vmm=${this.vehicleMakeModel}&y=${this.year}&it=${this.insuranceType}&vv=${this.vehicleValue}&pi=${this.preferredInsurer}&p=${this.plan}&rw=${this.roadWorthiness}&hp=${this.hackneyPermit}&vl=${this.vehicleLicense}&ovm=${this.otherVehicleMake}&ovmm=${this.otherVehicleMakeModel}`, '_blank');
                
                // window.location.href = `particulars?vt=${this.vehicleType}&vm=${this.vehicleMake}&vmm=${this.vehicleMakeModel}&y=${this.year}&it=${this.insuranceType}&vv=${this.vehicleValue}&pi=${this.preferredInsurer}&p=${this.plan}&rw=${this.roadWorthiness}&hp=${this.hackneyPermit}&vl=${this.vehicleLicense}&ovm=${this.otherVehicleMake}&ovmm=${this.otherVehicleMakeModel}`;
            },
            goToVehicleReg(){
                window.location.href=`vehicle_reg?vt=${this.vehicleTypeNewVehicle}&vm=${this.vehicleMakeNewVehicle}&vmm=${this.vehicleMakeModelNewVehicle}&y=${this.yearNewVehicle}&it=${this.insuranceTypeNewVehicle}&vv=${this.vehicleValueNewVehicle}&pi=${this.preferredInsurerNewVehicle}&p=${this.planNewVehicle}&npt=${this.numberPlateTypeNewVehicle}&ovm=${this.otherVehicleMakeNewVehicle}&ovmm=${this.otherVehicleMakeModelNewVehicle}`;
            },
            goToChangeOwnership(){

                window.open(`change_ownership?vt=${this.vehicleTypeOwnership}&vm=${this.vehicleMakeOwnership}&vmm=${this.vehicleMakeModelOwnership}&y=${this.yearOwnership}&vle=${this.vehicleLicenseExpiryOwnership}&rt=${this.registrationTypeOwnership}&npt=${this.numberPlateTypeOwnership}`, '_blank')

                // window.location.href=`change_ownership?vt=${this.vehicleTypeOwnership}&vm=${this.vehicleMakeOwnership}&vmm=${this.vehicleMakeModelOwnership}&y=${this.yearOwnership}&vle=${this.vehicleLicenseExpiryOwnership}&rt=${this.registrationTypeOwnership}&npt=${this.numberPlateTypeOwnership}`;
            },
            goToVehiclePermit(){

                window.open(`vehicle_permit?vp=${this.permitsOtherVehicle}`, '_blank')

                // window.location.href=`change_ownership?vt=${this.vehicleTypeOwnership}&vm=${this.vehicleMakeOwnership}&vmm=${this.vehicleMakeModelOwnership}&y=${this.yearOwnership}&vle=${this.vehicleLicenseExpiryOwnership}&rt=${this.registrationTypeOwnership}&npt=${this.numberPlateTypeOwnership}`;
            },
            setVehicleDetailsFromURL(){

                this.setFromURL = true;

                const urlParams = new URLSearchParams(window.location.search);

                let vehicleType = "";
                let vehicleMake = "";
                let vehicleMakeModel = "";
                let year = "";
                let insuranceType = "";
                let vehicleValue = "";
                let preferredInsurer = "";
                let plan = "";
                let roadWorthiness = "";
                let hackneyPermit = "";
                let vehicleLicense = "";
                let numberPlateType = "";
                let otherVehicleMake = "";
                let otherVehicleMakeModel = "";
                let vehicleLicenseExpiry = '';
                let registrationType = '';
                let vehiclePermits = '';

                if(urlParams.has('vt')){
                    vehicleType = urlParams.get('vt');
                }
                if(urlParams.has('vm')){
                    vehicleMake = urlParams.get('vm');
                }
                if(urlParams.has('vmm')){
                    vehicleMakeModel = urlParams.get('vmm');
                }
                if(urlParams.has('y')){
                    year = urlParams.get('y');
                }
                if(urlParams.has('it')){
                    insuranceType = urlParams.get('it');
                }
                if(urlParams.has('vv')){
                    vehicleValue = urlParams.get('vv');
                }
                if(urlParams.has('pi')){
                    preferredInsurer = urlParams.get('pi');
                }
                if(urlParams.has('p')){
                    plan = urlParams.get('p');
                }
                if(urlParams.has('rw')){
                    roadWorthiness = urlParams.get('rw');
                }
                if(urlParams.has('hp')){
                    hackneyPermit = urlParams.get('hp');
                }
                if(urlParams.has('vl')){
                    vehicleLicense = urlParams.get('vl');
                }
                if(urlParams.has('npt')){
                    numberPlateType = urlParams.get('npt');
                }
                if(urlParams.has('ovm')){
                    otherVehicleMake = urlParams.get('ovm');
                }
                if(urlParams.has('ovmm')){
                    otherVehicleMakeModel = urlParams.get('ovmm');
                }
                if(urlParams.has('vle')){
                    vehicleLicenseExpiry = urlParams.get('vle');
                }
                if(urlParams.has('rt')){
                    registrationType = urlParams.get('rt');
                }
                if(urlParams.has('vp')){
                    vehiclePermits = urlParams.get('vp');
                }

                this.vehicleType = vehicleType;
                this.vehicleMake = vehicleMake;
                this.vehicleMakeModel = vehicleMakeModel;
                this.year = "" + year;
                this.insuranceType = insuranceType;
                this.vehicleValue = vehicleValue;
                this.preferredInsurer = preferredInsurer;
                this.plan = plan;
                this.roadWorthiness = roadWorthiness;
                this.hackneyPermit = hackneyPermit;
                this.vehicleLicense = vehicleLicense;
                this.numberPlateType = numberPlateType;
                this.otherVehicleMake = otherVehicleMake;
                this.otherVehicleMakeModel = otherVehicleMakeModel;
                this.vehicleLicenseExpiry = vehicleLicenseExpiry;
                this.registrationType = registrationType;
                this.permits = vehiclePermits;

                console.log(this.permits);

            },
            unsetVehiclDetails(){
                this.vehicleType = "";
                this.vehicleMake = "";
                this.vehicleMakeModel = "";
                this.year = "";
            },
        },
        watch: {
            vehicleMake() {
                this.fetchModel().
                then((data) => {
                    
                }).
                catch((error) => {
                    this.vehicleMake = "";
                    this.finishedFetchingModels = true;
                    this.stillFetchingModels = false;
                    alert(error)
                }); 

            },
            vehicleMakeNewVehicle() {
                this.fetchModelNewVehicle().
                then((data) => {
                    
                }).
                catch((error) => {
                    this.vehicleMakeNewVehicle = "";
                    this.finishedFetchingModelsNewVehicle = true;
                    this.stillFetchingModelsNewVehicle = false;
                    alert(error)
                }); 

            },
            vehicleMakeOwnership() {
                this.fetchModelOwnership().
                then((data) => {
                    
                }).
                catch((error) => {
                    this.vehicleMakeOwnership = "";
                    this.finishedFetchingModelsOwnership = true;
                    this.stillFetchingModelsOwnership = false;
                    alert(error)
                }); 

            },
            // year(){
            //     this.fetchModel();
            // }
        },
        mounted(){

            if(window.location.pathname.includes("particulars")
                || window.location.pathname.includes("vehicle_reg")
                || window.location.pathname.includes("change_ownership")
                || window.location.pathname.includes("vehicle_permit")){
                this.setVehicleDetailsFromURL();
            }

            // if(this.insuranceType == "comprehensive_insurance"){
            //     let url = `admin/ajax_admin/get_insurance_plans.php?insurerId=${this.preferredInsurer}`;
            //     axios.get(url).then((data) => {

            //     })
            // }
            
            var app = this;
            jQuery(".select2").select2({
                placeholder: function(){
                    $(this).data('placeholder');
                }
            })
            
            $(".permits").on('change', function(e){
                app.permitsOtherVehicle = $(this).val()
                console.log(app.permits);
            });

            

            
        }
    })
</script>

