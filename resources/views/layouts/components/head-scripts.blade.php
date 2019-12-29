
<script>
    window.key = "{{Auth::check() ? Auth::user()->api_token : ''}}";

  function baseURL(){
      return "{{env('APP_URL')}}";
  }
  function apiURL(endpoint = ''){
    let url = `${baseURL()}/api${endpoint}`;
    if(window.key !== null){
      return `${url}${endpoint.split('?').length > 1 ? '&' : '?'}api_token=${window.key}`
    }
    return url;
  }

  // find the id of an object in a json array
  function getIndex(array, object){
    return array.findIndex(obj => obj.id === object.id);
  }
  // return an object specified by id from an array
  function getItem(array, object){
    return array.find(obj => obj.id === object.id);
  }
  // check if an object exist in an array
  function itemExist(array, object){
    let index = getIndex(array, object);
    return index === undefined || index < 0 ? false : true
  }
  // remove an object from an array
  function removeItem(array, object){
    if(itemExist(array, object)){
      array.splice(getIndex(array,object),1);
      return true;
    }
    return false;
  }

  function timeDiff(timestamp){
    let date = new Date((timestamp*1000));
    let now = new Date();
    let seconds_difference = now.getTime() - date.getTime();
    let diff = '';
    if(seconds_difference > 604800000){
      diff = Math.floor(seconds_difference/604800000)+'w'; // estimate in weeks
    }else if(seconds_difference > 86400000){
      diff = Math.floor(seconds_difference/86400000)+'d'; // estimate in days
    }else if(seconds_difference > 3600000){
      diff = Math.floor(seconds_difference/3600000)+'h'; // estimate in hours
    }else if(seconds_difference > 60000){
      diff = Math.floor(seconds_difference/60000)+'m'; // estimate in minutes
    }else{
      diff = Math.floor(seconds_difference/1000)+'s' //estimate in seconds
    }
    return diff+' '+date.toDateString();
  }

  function toastError(err,message=''){
      switch(err.status){
          case 401:
              toastr.error(`${message} <a href="${baseURL()}/login">Login first</a>`);
          break;
          case 500:
              toastr.error(`${message} Something went wrong`);
          break;
          default:
              toastr.error(`Server error: ${err.statusText}. ${message}`);
          break;
      }
  }
</script>
{{-- @include('layouts.components.typeahead.tag') --}}
<!-- Extra script that should live in the head -->
@yield('h-scripts')