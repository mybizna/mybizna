import {
    RouterView
} from 'vue-router';

import filters from "@/utils/filters";
import fetchComponent from "@/utils/fetchComponent";


window.$filters = filters;
window.$func = filters;
window.$methods = filters;


const fetchComponentFunc = (comp_path) => {
    return fetchComponent(comp_path);
}

//xxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxx

function path_updater(route) {

    if (route.component == 'router_view') {
        route.component = RouterView;
    } else {
        route.component = fetchComponentFunc(route.component);
    }

    if (Object.prototype.hasOwnProperty.call(route, 'children') && route.children.length > 0) {

        route.children.forEach(child => {
            return path_updater(child);

        });
    }

    return route;
}

export default async function (router) {

    var routes = [];

    // Make a request for a auto discovering modules.
    await window.axios.get(window.base_url + '/api/discover_modules');

    // Make a request for available Fetch Routes.
    await window.axios.get(window.base_url + '/api/fetch_routes')
        .then(function (response) {
            // handle success
            routes = response.data.routes;
        })
        .catch(function (error) {
            // handle error
        });

    let routes_keys = Object.keys(routes);

    routes_keys.forEach(key => {
        var new_routes = path_updater(routes[key]);

        router.addRoute(new_routes);

    })
}
