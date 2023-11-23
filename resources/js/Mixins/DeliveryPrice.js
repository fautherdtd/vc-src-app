import haversine from "haversine";

const start = {
    latitude: 42.056954,
    longitude: 48.305317
}

const distancePrice = (end) => {
    const distanceKM = haversine(start, end);
    const landingPrice = distanceKM > 15 ? 40 : 20;
    const roundPrice = distanceKM > 15 ? 30 : 18;
    let distance = Math.ceil(Math.ceil(distanceKM) + + Math.floor(10));
    return Math.ceil(landingPrice + (Math.ceil(distance * roundPrice)));
}

export default distancePrice;
