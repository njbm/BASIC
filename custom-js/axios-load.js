

function blockExists(selector) {
   return document.querySelector(selector) !== null;
}

function showBlockLoading(blockId) {
   let selector = `[data-block="${blockId}"]`;
   if (blockExists(selector)) Notiflix.Block.standard(selector);
}

function hideBlockLoading(blockId) {
   let selector = `[data-block="${blockId}"]`;
   if (blockExists(selector)) Notiflix.Block.remove(selector);
}

// Minify for data-block  have to keep 3 function

axios.interceptors.request.use(config=>{const blockId=config.meta?.blockId;if(blockId)showBlockLoading(blockId);return config},error=>Promise.reject(error));axios.interceptors.response.use(response=>{const blockId=response.config.meta?.blockId;if(blockId)hideBlockLoading(blockId);return response},error=>{const blockId=error.config?.meta?.blockId;if(blockId)hideBlockLoading(blockId);return Promise.reject(error)});




// Type 1 by data data-block="" 
function blockExists(selector) {
   return document.querySelector(selector) !== null;
}

function showBlockLoading(blockId) {
   let selector = `[data-block="${blockId}"]`;
   if (blockExists(selector)) Notiflix.Block.standard(selector);
}

function hideBlockLoading(blockId) {
   let selector = `[data-block="${blockId}"]`;
   if (blockExists(selector)) Notiflix.Block.remove(selector);
}

axios.interceptors.request.use(config => {
   // Check if meta.blockId exists and show loading for that block
   const blockId = config.meta?.blockId;
   if (blockId) showBlockLoading(blockId);
   return config;
}, error => (Promise.reject(error)));

axios.interceptors.response.use(response => {
   // Check if meta.blockId exists and hide loading for that block
   const blockId = response.config.meta?.blockId;
   if (blockId) hideBlockLoading(blockId);
   return response;
}, error => {
   const blockId = error.config?.meta?.blockId;
   if (blockId) hideBlockLoading(blockId);
   return Promise.reject(error);
});














// Minify code for notiflix block loading by class 
const n=".nbLoad";function e(){return null!==document.querySelector(n)}function o(){e()&&Notiflix.Block.remove(n)}axios.interceptors.request.use(t=>(e()&&Notiflix.Block.standard(n),t),t=>(o(),Promise.reject(t))),axios.interceptors.response.use(t=>(o(),t),t=>(o(),Promise.reject(t)));



//Type 1 by class
function blockExists(selector) {
   return document.querySelector(selector) !== null;
}

axios.interceptors.request.use(config => {
   if (blockExists('.nbLoad')) {
       Notiflix.Block.standard('.nbLoad'); // Show loading only if the element exists
   }
   return config;
}, error => {
   if (blockExists('.nbLoad')) {
       Notiflix.Block.remove('.nbLoad'); // Ensure loading is removed only if the element exists
   }
   return Promise.reject(error);
});

axios.interceptors.response.use(response => {
   if (blockExists('.nbLoad')) {
       Notiflix.Block.remove('.nbLoad'); // Hide loading only if the element exists
   }
   return response;
}, error => {
   if (blockExists('.nbLoad')) {
       Notiflix.Block.remove('.nbLoad'); // Hide loading even on response error
   }
   return Promise.reject(error);
});


 
//Type 2 by class
const nbLoad = '.nbLoad';

function blockExists() {
    return document.querySelector(nbLoad) !== null;
}

function removeBlock() {
    if (blockExists()) Notiflix.Block.remove(nbLoad);
}

axios.interceptors.request.use(config => {
    if (blockExists()) Notiflix.Block.standard(nbLoad);
    return config;
}, error => (removeBlock(), Promise.reject(error)));

axios.interceptors.response.use(response => (removeBlock(), response), 
    error => (removeBlock(), Promise.reject(error))
);




