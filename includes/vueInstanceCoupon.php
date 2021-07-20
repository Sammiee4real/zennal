<script type="application/javascript" src="https://cdn.jsdelivr.net/npm/vue@2.6.12/dist/vue.js"></script>
<script type="application/javascript" src="https://cdn.jsdelivr.net/npm/axios/dist/axios.min.js"></script>

<script type="application/javascript">
    const app = new Vue({
        el: '#appWrapper',
        data: {

            amountToPayEmail: <?php echo ($total); ?>,
            walletBalanceEmail: <?php echo $wallet_balance; ?>,
            remainingWalletBalanceEmail: <?php echo $wallet_balance; ?>,
            removeFromWalletEmail: false,
            regId: "",
            couponCodeEmail: "",
            couponAppliedEmail: false,
            couponDiscountEmail: null,
            showApplyCouponBtnEmail: false,
            showRemoveCouponBtnEmail: false,
            couponErrorMessageEmail: "",


            amountToPay: <?php echo ($total); ?>,
            walletBalance: <?php echo $wallet_balance; ?>,
            remainingWalletBalance: <?php echo $wallet_balance; ?>,
            removeFromWallet: false,
            regId: "",
            couponCode: "",
            couponApplied: false,
            couponDiscount: null,
            showApplyCouponBtn: false,
            showRemoveCouponBtn: false,
            couponErrorMessage: "",

        },
        methods: {
            applyCouponCodeEmail(query){

                const url = "ajax/apply_coupon_code.php"

                var formData = new FormData();
                formData.append("query", query);
                formData.append("coupon_code", this.couponCodeEmail);
                formData.append("reg_id", this.regId);

                axios.post(url, formData, {
                    headers: {
                        'Content-type': 'application/x-www-form-urlencoded',
                    }
                }).then((response) => {

                    const data = response.data;
                    let message = data.message;
                    const status = data.status;

                    if(status == 1){

                        this.couponAppliedEmail = true;
                        this.couponDiscountEmail = parseFloat(data.discount);

                        this.showApplyCouponBtnEmail = false;
                        this.showRemoveCouponBtnEmail = true;

                    }else if(status == 0){
                        this.couponErrorMessageEmail = message;
                    }

                }).catch((error) => {

                })

            },
            removeCouponCodeEmail(){

                this.couponAppliedEmail = false;

                this.couponCodeEmail = "";

            },

            applyCouponCode(query){

                const url = "ajax/apply_coupon_code.php"
                const request = {
                    query,
                    coupon_code: this.couponCode,
                    reg_id: this.regId,
                }

                var formData = new FormData();
                formData.append("query", query);
                formData.append("coupon_code", this.couponCode);
                formData.append("reg_id", this.regId);

                axios.post(url, formData, {
                    headers: {
                        'Content-type': 'application/x-www-form-urlencoded',
                    }
                }).then((response) => {

                    const data = response.data;
                    let message = data.message;
                    const status = data.status;

                    if(status == 1){

                        this.couponApplied = true;
                        this.couponDiscount = parseFloat(data.discount);

                        this.showApplyCouponBtn = false;
                        this.showRemoveCouponBtn = true;

                    }else if(status == 0){
                        this.couponErrorMessage = message;
                        console.log(this.couponErrorMessage);
                    }

                }).catch((error) => {

                })

            },
            removeCouponCode(){

                this.couponApplied = false;

                this.couponCode = "";

            },
        },
        watch: {
            removeFromWalletEmail(val){
                // If remove from wallet is checked
                if(val){
                    if(this.amountToPayEmail >= this.walletBalanceEmail){
                        this.amountToPayEmail = this.amountToPayEmail - this.walletBalanceEmail;
                        this.remainingWalletBalanceEmail = 0;
                    }else{
                        this.amountToPayEmail = 0;
                        this.remainingWalletBalanceEmail = this.walletBalanceEmail - this.amountToPayEmail;
                    }
                }else{
                    this.amountToPayEmail = this.amountToPayEmail + this.walletBalanceEmail;
                    this.remainingWalletBalanceEmail = this.walletBalanceEmail;
                }
            },
            couponCodeEmail(val){

                this.couponAppliedEmail = false;

                this.couponErrorMessageEmail = "";

                if(val){
                    this.showApplyCouponBtnEmail = true;
                    this.showRemoveCouponBtnEmail = false;
                }else{
                    this.showApplyCouponBtnEmail = false;
                    this.showRemoveCouponBtnEmail = false;
                }

            },
            couponAppliedEmail(val){
                if(val){
                    this.amountToPayEmail = this.amountToPayEmail - this.couponDiscountEmail
                }else{
                    this.amountToPayEmail = this.amountToPayEmail + this.couponDiscountEmail
                    this.couponDiscountEmail = 0;
                }
            },



            removeFromWallet(val){
                // If remove from wallet is checked
                if(val){
                    if(this.amountToPay >= this.walletBalance){
                        this.amountToPay = this.amountToPay - this.walletBalance;
                        this.remainingWalletBalance = 0;
                    }else{
                        this.amountToPay = 0;
                        this.remainingWalletBalance = this.walletBalance - this.amountToPay;
                    }
                }else{
                    this.amountToPay = this.amountToPay + this.walletBalance;
                    this.remainingWalletBalance = this.walletBalance;
                }
            },
            couponCode(val){

                this.couponApplied = false;

                this.couponErrorMessage = "";

                if(val){
                    this.showApplyCouponBtn = true;
                    this.showRemoveCouponBtn = false;
                }else{
                    this.showApplyCouponBtn = false;
                    this.showRemoveCouponBtn = false;
                }

            },
            couponApplied(val){
                if(val === true){
                    this.amountToPay = this.amountToPay - this.couponDiscount
                }else{
                    this.amountToPay = this.amountToPay + this.couponDiscount
                    this.couponDiscount = 0;
                }
            },
            
        },
        filters: {
            displayedCouponDiscount(val){
                if(val === 0){
                    return "₦"+val.toString();
                }else if(val > 0){
                    return "-"+"₦"+val.toString();
                }

                return "₦"+"0";
            },
            displayReadableMoney(value){
                return value.toString().replace(/\B(?=(\d{3})+(?!\d))/g, ',');
            },
            displayNairaReadableMoney(value){
                return "₦"+value.toString().replace(/\B(?=(\d{3})+(?!\d))/g, ',');
            }
        },
        mounted(){

            const urlParams = new URLSearchParams(window.location.search);

            var regId = "";

            if(urlParams.has('reg_id')){
                regId = urlParams.get('reg_id');
            }
            if(urlParams.has('rec_id')){
                regId = urlParams.get('rec_id');
            }
            if(urlParams.has('unique_id')){
                regId = urlParams.get('unique_id');
            }

            this.regId = regId;

        }
    })
</script>

