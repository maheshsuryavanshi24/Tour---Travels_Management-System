SELECT tours.*, buses.bus_name
FROM tours
LEFT JOIN bus_tour ON tours.id = bus_tour.tour_id
LEFT JOIN buses ON buses.id = bus_tour.bus_id