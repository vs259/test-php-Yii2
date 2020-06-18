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
    
        <div class="columns medium-4 rubrics" v-for="(result, index) in rubrics"  v-if="isShowRubrics">
          <div class="card">
            <div class="card-section">
              <p> {{ result.rubric_title }} </p>
            </div>
          </div>
        </div>
        

        <div class="columns medium-4 news" v-for="(result, index) in news" v-if="isShowNews">
          <div class="card">
            <div class="card-section">
              <p><b> {{ result.news_title }} </b></p>
            </div>
              <br>
            <div class="card-section">
              <p> {{ result.news_text }} </p>
            </div>
          </div>
              <br>
              <br>
        </div>

    </div>
</div>
</article>


<script>

let app = new Vue({
    el: '#app',
    data: {
        header: '',
        rubrics: {},
        news: {},
        isShowRubrics: false,
        isShowNews: false,
    },
    
    mounted() {
    },

    methods: {
        showRubricList: function() {
            this.header = 'РУБРИКИ';
            this.isShowRubrics = true;
            this.isShowNews = false;
            axios.get("http://dingo.moscow/web/index.php/?r=rubric").then(response => {
              console.log(response);
            this.rubrics = response.data
            })
         },
        showNews: function() {
            this.header = 'НОВОСТИ';
            this.isShowRubrics = false;
            this.isShowNews = true;
            axios.get("http://dingo.moscow/web/index.php/?r=news").then(response => {
              console.log(response);
            this.news = response.data
            })
        },
    },
});


</script>

