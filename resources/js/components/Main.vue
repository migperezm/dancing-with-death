<script>
import DatePicker from "vue2-datepicker";
import "vue2-datepicker/index.css";
import FooterComponent from "./FooterComponent.vue";
import BannerComponent from "./BannerComponent.vue";
export default {
    data() {
        let nowDate = new Date().toISOString().slice(0, 10);

        return {
            arrayAppointments: [],
            date: nowDate,
            email: "",
            errors: [],
            horasTomadas: [],
            hoursArray: [],
            nowDate,

            today: new Date().toISOString().slice(0, 10),
            disableDates: [
                { end: new Date(Date.now() - 8640000) },
                { weekdays: [1, 7] },
            ],
            lang: {
                formatLocale: {
                    firstDayOfWeek: 1,
                },
            },
        };
    },
    components: { FooterComponent, BannerComponent },
    methods: {
        resetHours() {         
            this.hoursArray = [];
            let hoy = new Date().toISOString().slice(0, 10);            
            if(this.date === hoy || this.date.toISOString().slice(0, 10) === hoy){      
                let h = new Date().getHours();      
                for (var i = h + 1; i <= 18; i++) {
                    this.hoursArray.push(i);
                }
            } else {
                for (var i = 9; i <= 18; i++) {
                    this.hoursArray.push(i);
                }
            }
        },
        getAppointments(date) {
            let me = this;
            let url = `/appointment?id=${date}`;
            me.resetHours();
            me.horasTomadas = [];
            axios
                .get(url)
                .then(function (response) {
                    response.data.forEach((h) => {
                        me.horasTomadas.push(`${h.appointment_time}`);
                    });
                    me.hoursArray = me.hoursArray.filter(function (val) {
                        return me.horasTomadas.indexOf(val.toString()) == -1;
                    });
                })
                .catch(function (error) {
                    console.log(error);
                });
        },
        validEmail: function () {
            var re =
                /^(([^<>()\[\]\\.,;:\s@"]+(\.[^<>()\[\]\\.,;:\s@"]+)*)|(".+"))@((\[[0-9]{1,3}\.[0-9]{1,3}\.[0-9]{1,3}\.[0-9]{1,3}\])|(([a-zA-Z\-0-9]+\.)+[a-zA-Z]{2,}))$/;
            return re.test(this.email);
        },
        checkForm() {
            this.errors = [];
            if (!this.email) {
                this.errors.push("Email required.");
                this.$refs.email.focus();
                return false;
            } else if (!this.validEmail(this.email)) {
                this.$refs.email.focus();
                this.errors.push("Valid email required.");
                return false;
            }
            return true;
        },
        createAppointment(id) {
            let me = this;
            if (this.checkForm()) {
                this.$fire({
                    title: "Create an appointment?",
                    showCancelButton: true,
                }).then((r) => {
                    if (r.value) {
                        let date = id.split("|");
                        let url = "/appointment/save";
                        axios
                            .post(url, {
                                date: new Date(date[0])
                                    .toISOString()
                                    .slice(0, 10),
                                time: date[1],
                                email: this.email,
                            })
                            .then(function (response) {
                                response.data == 2
                                    ? me.$fire({
                                          title: "Don't be silly!!",
                                          text: "You already have an appointment for today!!!",
                                          type: "error",
                                      })
                                    : me.$fire({
                                          title: "Gratz!!",
                                          text: "Your appointment was scheduled, get ready!!!",
                                          type: "success",
                                      });
                                me.getAppointments(
                                    new Date(date[0]).toISOString().slice(0, 10)
                                );
                            })
                            .catch(function (error) {
                                console.log(error);
                            });
                    }
                });
            }
        },
        changeDate() {
            this.nowDate = this.date.toISOString().slice(0, 10);
            this.getAppointments(this.date.toISOString().slice(0, 10));
        },
        disableWeekends(date) {
            const day = new Date(date).getDay();
            return (
                date <= new Date(this.today) ||
                date >= new Date(2023, 0, 1) ||
                day === 0 ||
                day === 6
            );
        },
    },
    mounted() {
        this.getAppointments(this.nowDate);
    },
};
</script>

<template>
    <div class="container col-lg-6 offset-lg-3 mt-4">
        <div class="container">
            <banner-component></banner-component>
            <div class="row">
                <div class="col-lg-4 offset-lg-4">
                    <div class="row justify-content-center">
                        <input
                            for="email"
                            ref="email"
                            placeholder="enter your email"
                            id="email"
                            v-model="email"
                            type="email"
                            class="form-control"
                        />

                        <date-picker
                            class="mt-2"
                            v-model="date"
                            :default-value="today"
                            ref="datepicker"
                            :disabled-date="disableWeekends"
                            :lang="lang"
                            @change="changeDate"
                        ></date-picker>
                        <div>
                            <div v-if="errors.length">
                                <div
                                    class="alert alert-danger text-sm-center mt-2"
                                    :key="error"
                                    v-for="error in errors"
                                >
                                    {{ error }}
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <br />
        <hr />
        <h2 class="mx-auto">
            <div v-if="hoursArray.length > 0">
                <strong>
                    <p class="text-sm-center" v-if="date">
                        😈 Calendar for {{ nowDate }} 😈
                    </p>
                </strong>
                <ul style="list-style: none">
                    <li v-for="hora in hoursArray" :key="hora">
                        <div
                            :id="`${date}|${hora}`"
                            :key="hora"
                            @click="createAppointment(`${date}|${hora}`)"
                            class="alert alert-success text-sm-center"
                        >
                            {{ hora + ":00" }}
                        </div>
                    </li>
                </ul>
            </div>
            <div v-else class="alert alert-danger text-sm-center">
                There's not more appointments availables for this date
                {{ nowDate }}
            </div>
        </h2>
        <footer-component></footer-component>
    </div>
</template>
