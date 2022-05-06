
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
        console.log(route.component);

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

    // Make a request for a user with a given ID
    await window.axios.get(window.base_url + '/api/discover_modules');

    // Make a request for a user with a given ID
    await window.axios.get(window.base_url + '/api/fetch_routes')
        .then(function (response) {
            // handle success
            console.log(response);

            response.data.routes.forEach(route => {


                var new_routes = path_updater(route);

                router.addRoute(new_routes);

            });
        })
        .catch(function (error) {
            // handle error
            console.log(error);
        });


}
