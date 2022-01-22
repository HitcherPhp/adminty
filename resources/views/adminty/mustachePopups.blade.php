<script id="mustache_popups" type="text/template">
    <div id="mustache_popups_container">
        <div id="sweet_overlay__add" class="sweet-overlay" tabindex="-1" style="display: block;"></div>
        <div id="sweet_alert__add" class="delete-alert sweet-alert hideSweetAlert"  style="display: block; margin-top: -250px; border: solid 1px black;">
            <div id="sa_error__add" class="sa-icon sa-error animateErrorIcon" style="display: @{{sa_error__add}};">
                <span class="sa-x-mark animateXMark">
                    <span class="sa-line sa-left"></span>
                    <span class="sa-line sa-right"></span>
                </span>
            </div>
            <div id="sa_warning__add" class="sa-icon sa-warning pulseWarning" style="display: @{{sa_warning__add}};">
                <span class="sa-body pulseWarningIns"></span>
                <span class="sa-dot pulseWarningIns"></span>
            </div>

            <div id="sa_success__add" class="sa-icon sa-success animate" style="display: @{{sa_success__add}};">
                <span class="sa-line sa-tip animateSuccessTip"></span>
                <span class="sa-line sa-long animateSuccessLong"></span>
                <div class="sa-placeholder"></div>
                <div class="sa-fix"></div>
            </div>

            <h2 id="header_title__add">@{{header_title__add}}</h2>
            <p id="content_title__add">@{{content_title__add}}</p>


            <div class="sa-button-container">
                <button class="cancel" id="cancel__add" name="cancel__add" tabindex="2" style="display: @{{cancel__add}}; box-shadow: none;">Отменить</button>
                <div class="sa-confirm-button-container">
                    <button class="confirm info_popup_button" id="confirm__add"  tabindex="1" style="display: @{{confirm__add}}" >Да</button>
                    <button class="confirm info_popup_button" id="ok__add"  tabindex="1" style="display: @{{ok__add}}" >Ок</button>
                </div>
            </div>
        </div>
    </div>

</script>
