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

        <div  class="columns medium-4 rubrics"  v-if="isShowRubrics">
          <div class="card">
            <div class="card-section" v-for="(result, index) in rubrics">
                <p>   
                    <a href="#" v-on:click="showRubricTree(result.rubric_id)"
                        v-on:mousedown.right="showRubricNews(result.rubric_id)"
                        @contextmenu.prevent
                       >{{ result.rubric_title }}</a>
                </p>
            </div>
          </div>
            <br>
            <p><i>Кликните по рубрике для получения списка вложенных рубрик</i></p>
            <p><i>Кликните по рубрике правой кнопкой для получения списка новостей выбранной рубрики</i></p>
        </div>
        
        <div class="columns medium-4 news" v-if="isShowRubricTree">
          <div class="card">
            <div class="card-section" v-for="(result, index) in rubrics" >
                <p>   
                    <a href="#" v-on:click="showRubricTreeNews(result.rubric_id);">{{ result.rubric_title }}</a>
                </p>
            </div>
          </div>
            <br>
            <p><i>Кликните по рубрике для получения списка всех новостей выбранной и вложенных рубрик</i></p>
        </div>    
            
        <div class="columns medium-4 news" v-if="isShowNews">
          <div class="card"  v-for="(result, index) in news">
            <div class="card-section">
              <p><b>
                    <a href="#" v-on:click="showRubricsForNews(result.news_id);">{{ result.news_title }}</a>
                  </b></p>
            </div>
              <br>
            <div class="card-section">
              <p> {{ result.news_text }} </p>
            </div>
          </div>
            <br>
            <p><i>Кликните по заголовку новости для получения списка рубрик, к которым принадлежит новость</i></p>
        </div>

        <div class="columns medium-4 news" v-if="isShowRubricsForNews">
          <div class="card"  v-for="(result, index) in rubrics">
            <div class="card-section">
                <p><small>{{ result.rubric_title }}</small></p>
            </div>
          </div>
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
        isShowRubricTree: false,
        isShowRubricsForNews: false,
    },
    
    mounted() {
    },

    methods: {
        showRubricList: function() {
            this.header = 'РУБРИКИ';
            this.isShowRubrics = true;
            this.isShowNews = false;
            this.isShowRubricTree = false;
            this.isShowRubricsForNews = false;
            axios.get("http://dingo.moscow/web/index.php/?r=rubric").then(response => {
            this.rubrics = response.data
            })
         },
        showNews: function() {
            this.header = 'НОВОСТИ';
            this.isShowRubrics = false;
            this.isShowRubricTree = false;
            this.isShowNews = true;
            this.isShowRubricsForNews = false;
            axios.get("http://dingo.moscow/web/index.php/?r=news").then(response => {
            this.news = response.data
            })
        },
        showRubricTree: function(index){
            this.header = 'Рубрика + дочернии, с учетом произвольного уровня вложенности';
            this.isShowRubrics = false;
            this.isShowNews = false;
            this.isShowRubricTree = true;
            this.isShowRubricsForNews = false;
            axios.get("http://dingo.moscow/web/index.php/?r=rubric&rubric_id=" + index).then(response => {
            this.rubrics = response.data
            })
        },
        showRubricNews: function(index){
            this.header = 'НОВОСТИ';
            this.isShowRubrics = false;
            this.isShowRubricTree = false;
            this.isShowNews = true;
            this.isShowRubricsForNews = false;
            axios.get("http://dingo.moscow/web/index.php/?r=news&rubric_id=" + index).then(response => {
            this.news = response.data
            })
        },
        showRubricTreeNews: function(index){
            this.header = 'НОВОСТИ';
            this.isShowRubrics = false;
            this.isShowRubricTree = false;
            this.isShowNews = true;
            this.isShowRubricsForNews = false;
            axios.get("http://dingo.moscow/web/index.php/?r=news&parent_id=" + index).then(response => {
            this.news = response.data
            })
        },
        showRubricsForNews: function(index){
            this.header = 'НОВОСТИ';
            this.isShowRubrics = false;
            this.isShowRubricTree = false;
            this.isShowNews = true;
            this.isShowRubricsForNews = true;
            axios.get("http://dingo.moscow/web/index.php/?r=news&id=" + index).then(response => {
            this.rubrics = response.data
            })
        },
     },
});


</script>

