let option = {};
option.pageLoadingMask = (function () {
    var maskDivId = "cdfd5f6428794b309256805748abe2b2";
    var closeCallbacks = [];
    var pageLoader = {
        show: function (doc, closeCallback) {
            if (doc === undefined) doc = window.document;
            if (doc.getElementById(maskDivId)) return;
            doc.body.innerHTML += `
            <div class="my-loading-shade" id="${maskDivId}">
                <div class="loader-wrapper ☯-bg fadeOut animated">
                    <div class='☯'></div>
                </div>
            </div>
            `;

            // doc.body.innerHTML += `
            // <div class="my-loading-shade" id="${maskDivId}">
            //     <div class="loader-wrapper">
            //         <div class="loader">
            //             <div class="roller"></div>
            //             <div class="roller"></div>
            //         </div>                    
            //         <div id="loader2" class="loader">
            //             <div class="roller"></div>
            //             <div class="roller"></div>
            //         </div>                    
            //         <div id="loader3" class="loader">
            //             <div class="roller"></div>
            //             <div class="roller"></div>
            //         </div>
            //     </div>
            // </div>
            // `;

            if (typeof closeCallback === "function") {
                if (typeof doc.docId !== "string") {
                    doc.docId = util.string.getUUID();
                }
                closeCallbacks[doc.docId] = closeCallback;
            }
        },
        remove: function (doc) {
            if (doc === undefined) doc = window.document;
            if (typeof doc.docId === "string") {
                var closeCallback = closeCallbacks[doc.docId];
                if (typeof closeCallback === "function") closeCallback();
                delete closeCallbacks[doc.docId];
            }
            var mask = doc.getElementById(maskDivId);
            if (mask) mask.parentNode.removeChild(mask);
            pageLoader = null;
        }
    };
    return pageLoader;
})();