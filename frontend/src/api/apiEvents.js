export const fetchEvents = () => {
    return fetch('/api/v1/events')
        .then(response => response.json())
}

export const createEvent = ({data}) => {
    const formData = new FormData()
    Object.keys(data).map(k => formData.append(k, data[k]))
    data.hasOwnProperty('conditions') && formData.set('conditions', JSON.stringify(data.conditions))
    return fetch('/api/v1/events', {
        method: 'POST',
        body: formData
    }).then(response => response.json())
}

export const deleteEventById = ({id}) => {
    return fetch(`/api/v1/events/${id}`, {
        method: 'DELETE',
    }).then(response => response.json())
}