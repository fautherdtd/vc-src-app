import haversine from "haversine";

const start = {
    latitude: 42.056954,
    longitude: 48.305317
}
const landingPrice = 100;

const distancePrice = (end) => {
    let distance = Math.ceil(Math.ceil(haversine(start, end)) + + Math.floor(10));
    console.log(distance);
    return Math.ceil(landingPrice + (Math.ceil(distance * 50)));
}

export default distancePrice;
