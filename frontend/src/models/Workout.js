import Model from './Model'

export default class Workout extends Model {
    // Set the resource route of the model
    resource() {
        return 'workouts'
    }
}
