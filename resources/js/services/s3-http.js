import axios from 'axios';

export default axios.create({
  baseURL: `${window.Laravel.baseUrl}/api`,
  headers: {
    common: {
        'X-Requested-With': 'XMLHttpRequest',
        'X-CSRF-TOKEN': window.Laravel.csrfToken
    }
  }
})
