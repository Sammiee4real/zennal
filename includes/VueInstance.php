<script type="application/javascript" src="https://cdn.jsdelivr.net/npm/vue@2.6.12/dist/vue.js"></script>
<!-- <script type="application/javascript" src="https://cdn.jsdelivr.net/npm/axios/dist/axios.min.js"></script> -->

<script type="application/javascript">
    const app = new Vue({
        el: '#appWrapper',
        data: {
            year: '',
            vehicleType: '',
            vehicleMake: '',
            vehicleMakeModel: '',
            vehicleMakeModels: [],
            finishedFetchingModels: false,
            stillFetchingModels: false,
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

                // console.log(data.results);
                // console.log(JSON.stringify(data, null, 2));

            },
            goToParticulars(){
                window.location.href=`particulars?vt=${this.vehicleType}&vm=${this.vehicleMake}&vmm=${this.vehicleMakeModel}&y=${this.year}`;
            },
            setVehicleDetailsFromURL(){

                this.setFromURL = true;

                const urlParams = new URLSearchParams(window.location.search);

                let vehicleType = "";
                let vehicleMake = "";
                let vehicleMakeModel = "";
                let year = "";

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

                this.vehicleType = vehicleType;
                this.vehicleMake = vehicleMake;
                this.vehicleMakeModel = vehicleMakeModel;
                this.year = "2014";
                console.log(typeof this.year);
            }
        },
        watch: {
            vehicleMake() {
                this.fetchModel().
                catch((error) => {
                    this.vehicleMake = "";
                    this.finishedFetchingModels = true;
                    this.stillFetchingModels = false;
                    alert(error)
                });
            },
            // year(){
            //     this.fetchModel();
            // }
        },
        created(){

            if(window.location.pathname.includes("particulars")){
                this.setVehicleDetailsFromURL();
            }

            

            
        }
    })
</script>