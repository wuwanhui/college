<div class="page" v-if="list!=null">
    第<span
            v-text="list.current_page"></span>页/共<span
            v-text="list.last_page"></span>页 共计<span v-text="list.total"></span>条
    <div class="btn-group" v-if="list.last_page>1">
        <button type="button" class="btn btn-default btn-sm" v-on:click="params.page=list.current_page-1"><i
                    class="fa fa-chevron-left"></i></button>
        <button type="button" class="btn btn-default btn-sm" v-on:click="params.page=list.current_page+1"><i
                    class="fa fa-chevron-right"></i></button>
    </div>
</div>
