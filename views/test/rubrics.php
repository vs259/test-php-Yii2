<!-- Вынужденная мера, чтобы отключить некоторые компоненты действующего сайта -->
<style>
    .slider, .turn, #w0, .div-logo{display:none;}
</style>

<script src="https://cdn.jsdelivr.net/npm/vue/dist/vue.js"></script>

<script src="https://unpkg.com/vue"></script>
<script src="https://unpkg.com/axios/dist/axios.min.js"></script>


<article>
<div class="container">

    <div id="app">
        
        <nav class="navbar navbar-default">
                <ul class="nav navbar-nav">
                        <li class="active"> <a @click="showRubricList">Рубрики</a></li>
                        <li> <a @click="showNews">Новости</a></li>
                </ul>
        </nav>

        <header>{{ header }} </header>
    
        <div class="columns medium-4" v-for="(result, index) in results">
          <div class="card">
            <div class="card-section">
              <p> {{ result.rubric_title }} </p>
            </div>
          </div>
        </div>
        
    </div>
</div>
</article>


<script>
// Пути к API    http://dingo.moscow/web/index.php/?r=rubric  - рубрики (список)

let app = new Vue({
    el: '#app',
    data: {
        header: '',
        results: {},
    },
    
    mounted() {
    },

    methods: {
        showRubricList: function() {
            this.header = 'РУБРИКИ';
            axios.get("http://dingo.moscow/web/index.php/?r=rubric").then(response => {
              console.log(response);
            this.results = response.data
            })
         },
        showNews: function() {
            this.header = 'НОВОСТИ';
            axios.get("http://dingo.moscow/web/index.php/?r=news").then(response => {
              console.log(response);
            this.results = response.data
            })
        },
    },
});


</script>

