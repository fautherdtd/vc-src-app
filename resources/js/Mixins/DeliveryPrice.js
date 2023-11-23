import haversine from "haversine";

const start = {
    latitude: 42.056954,
    longitude: 48.305317
}
const landingPrice = 50;

const distancePrice = (end) => {
    let distance = Math.ceil(Math.ceil(haversine(start, end)) + + Math.floor(10));
    return Math.ceil(landingPrice + (Math.ceil(distance * 30)));
}

export default distancePrice;
