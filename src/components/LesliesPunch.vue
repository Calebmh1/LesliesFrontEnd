<template>
    <div>
        <form>
            <fieldset>
                <form>
                <legend>{{ legend }}</legend>
                <h2>{{currentDate()}}</h2>
                <h2>{{currentTime()}}</h2>
                <h3>Hello, {{getEmpName()}} {{getEmpLastName()}}</h3>
                    <input type="radio" value="punchIn" v-model="punchSelect">
                    <label for="one">Punch In</label>

                    <hr />
                    <input type="radio" value="break" v-model="punchSelect">
                    <label for="one">15 min break</label>

                    <input type="radio" value="lunch" v-model="punchSelect">
                    <label for="one">Lunch Break</label>

                    <input type="radio" value="punchOut" v-model="punchSelect">
                    <label for="one">Punch Out</label>

                    <button v-on:click.prevent="selection()">Punch</button>
                </form>

            </fieldset>
        </form>
    </div>
</template>

<script>
    import store from "@/store/index.js";
    import moment from "moment";

    export default {
        
        name: "LesliesPunch",
            props: {
        legend: {
            type: String,
            default: "Leslies Warehouse",
        }
    },
        created: function() {
            this.getEmpName();
            this.getEmpLastName();
        },
        data: function() {
           return {
               punchSelect: "",
           } 
        },
        methods: {
            getEmpName: function() {
                return store.state.empName;
            },
            getEmpLastName: function() {
                return store.state.empLastName;
            },
            selection: function() {
                
                //var current = moment();
                var current = moment("06:55:01", "HH:mm:ss");
                var early = moment("06:55:00", "HH:mm:ss");
                var late = moment("07:05:00", "HH:mm:ss");
                //console.log(early);
                //console.log(late);
                //console.log(this.currentTime());

                if(current.isBefore(early)) {
                    this.$alert("You are not allowed to punch in before 6:55am");
                } else if(current.isAfter(late)) {
                    var warningDateTime = new Date()
                    const warningPayload = {
                        employeeId: store.state.empID,
                        warningType: "Late",
                        warningDescription: "Late punch In",
                        warningDate: warningDateTime,
                    };
                    var jsonPayload = JSON.stringify(warningPayload);

                    //console.log("late");
                    var call = "https://leslieswarehouseapi20220422190240.azurewebsites.net/api/Warnings/";
                    fetch(call,{method: "POST", headers: {'Content-Type': 'application/json'},
                        body: jsonPayload});
                } else if (current.isBefore(late) && current.isAfter(early)) {
                    if(this.punchSelect == "punchIn") {
                    this.punchIn();
                    }else if(this.punchSelect == "break") {
                        this.break();
                    }else if(this.punchSelect == "lunch") {
                        this.lunch();
                    }else if(this.punchSelect == "punchOut") {
                        this.punchOut();
                    }
                }                
            },
            currentTime: function() {
            return new Date().toLocaleTimeString();
            },
            currentDate: function() {
            return new Date().toLocaleDateString();
            },
            punchIn: function() {
                if(!store.state.cooldown){
                    var timeStamp = new Date();
                    const payload = {
                        employeeId: store.state.empID, 
                        punchInDateTime: timeStamp, 
                        punchInType: "Punch In"  
                    }
                    //console.log(payload);

                    var jsonPayload = JSON.stringify(payload);
                    
                    moment(timeStamp).format("YYYY-MM-DD HH:mm:ss");
                    //console.log(timeStamp);

                    if(store.state.empName && store.state.empLastName && store.state.empID) {
                        var call = "https://leslieswarehouseapi20220422190240.azurewebsites.net/api/punchIns";

                        fetch(call,{method: "POST", headers: {'Content-Type': 'application/json'},
                            body: jsonPayload});

                            store.state.cooldown = true;
                            store.state.confirmation = "Punch In Successful";
                            this.$confirm(store.state.confirmation).then(() => {
                                this.$router.push("/lesliesLogin");
                            });


                    } else {
                        this.$alert("Error Please try again");
                        this.$router.push("/lesliesLogin");
                    }
                } else {
                    var alert = store.state.empName + " " + store.state.empLastName + " has punched too recently";
                    this.$alert(alert);
                    this.$router.push("/lesliesLogin");
                }
            },
            break: function() {
                if(!store.state.cooldown){
                    var timeStamp = new Date();
                    const payload = {
                        employeeId: store.state.empID, 
                        punchOutDateTime: timeStamp, 
                        punchOutType: "Break"  
                    }
                    //console.log(payload);

                    var jsonPayload = JSON.stringify(payload);
                    
                    moment(timeStamp).format("YYYY-MM-DD HH:mm:ss");

                    if(store.state.empName && store.state.empLastName && store.state.empID) {
                        var call = "https://leslieswarehouseapi20220422190240.azurewebsites.net/api/punchOuts";

                        fetch(call,{method: "POST", headers: {'Content-Type': 'application/json'},
                            body: jsonPayload});

                            store.state.cooldown = true;
                            store.state.confirmation = "Break punch successful";
                            this.$confirm(store.state.confirmation).then(() => {
                                this.$router.push("/lesliesLogin");
                            });

                    } else {
                        this.$alert("Error Please try again");
                        this.$router.push("/lesliesLogin");
                    }
                } else {
                var alert = store.state.empName + " " + store.state.empLastName + " has punched too recently";
                this.$alert(alert);
                this.$router.push("/lesliesLogin");
                }
                
            },
            lunch: function() {
                if(!store.state.cooldown){
                    var timeStamp = new Date();
                    const payload = {
                        employeeId: store.state.empID, 
                        punchOutDateTime: timeStamp, 
                        punchOutType: "Lunch"  
                    }
                    //console.log(payload);

                    var jsonPayload = JSON.stringify(payload);
                    
                    moment(timeStamp).format("YYYY-MM-DD HH:mm:ss");

                    if(store.state.empName && store.state.empLastName && store.state.empID) {
                        var call = "https://leslieswarehouseapi20220422190240.azurewebsites.net/api/punchOuts";

                        fetch(call,{method: "POST", headers: {'Content-Type': 'application/json'},
                            body: jsonPayload});
                        
                        store.state.cooldown = true; 
                        store.state.confirmation = "Lunch punch successful"; 
                        this.$confirm(store.state.confirmation).then(() => {
                                this.$router.push("/lesliesLogin");
                            });   

                    } else {
                        this.$alert("Error Please try again");
                        this.$router.push("/lesliesLogin");
                    }
                } else {
                    var alert = store.state.empName + " " + store.state.empLastName + " has punched too recently";
                    this.$alert(alert);
                    this.$router.push("/lesliesLogin");
                }
            },
            punchOut: function() {
                if(!store.state.cooldown){
                    var timeStamp = new Date();
                    const payload = {
                        employeeId: store.state.empID, 
                        punchOutDateTime: timeStamp, 
                        punchOutType: "Punch Out"  
                    }
                    //console.log(payload);

                    var jsonPayload = JSON.stringify(payload);
                    
                    moment(timeStamp).format("YYYY-MM-DD HH:mm:ss");

                    if(store.state.empName && store.state.empLastName && store.state.empID) {
                        var call = "https://leslieswarehouseapi20220422190240.azurewebsites.net/api/punchOuts";

                        fetch(call,{method: "POST", headers: {'Content-Type': 'application/json'},
                            body: jsonPayload});

                            store.state.cooldown = true;
                            store.state.confirmation = "Punch out successful";
                            this.$confirm(store.state.confirmation).then(() => {
                                this.$router.push("/lesliesLogin");
                            });

                    } else {
                        this.$alert("Error Please try again");
                        this.$router.push("/lesliesLogin");
                    }
                }else {
                    var alert = store.state.empName + " " + store.state.empLastName + " has punched too recently";
                    this.$alert(alert);
                    this.$router.push("/lesliesLogin");
                            
                }
            },
            
        }, 
    }
</script>





<style scoped>
    fieldset {
        background-color: lightblue;
        max-width: 300px;
        margin: auto;
        padding: 20px;
    }
    legend {
        font-weight: bold;
        color: white;
        background: blueviolet;
        padding: 5px;
        border: solid 1px black;
        font-size: 1.2em;
    }
    label {
        display: block;
        margin-bottom: 5px;
        
    }
    button{
        color: white;
        background: blueviolet;
        font-size: 1.2em;
        font-weight: bold;
        padding: 5px;
        margin-top: 10px;
    }
    form{
        
        background: white;
        padding: 10px;
    }
    h2{
        padding: 5px;
    }
    input{
        padding: 5px;
        margin: 10px;
    }
</style>