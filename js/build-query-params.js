// yarn add lodash
import _ from 'lodash'

/**
 * @var params 查询参数 Object
 * @var rules 规则 Object 
 */
export default (params, rules) => {
    let obj = {}
    for (const key in params) {
        if (params[key] === '' || params[key] === null) {
            continue
        }
        if (!_.has(rules, key)) {
            obj[key] = params[key]
            continue
        }
        switch (rules[key]) {
            case 'like':
            case '=':
            case '<':
            case '<=':
            case '>':
            case '>=':
            case 'boolean':
                obj[key] = general(params[key], rules[key])
                break;
            case 'between-date':
                obj[key] = betweenDate(params[key], rules[key])
                break;

            default:
                obj[key] = params[key]
                break;
        }

    }
    return obj
}

function general(params, operation) {
    return `${operation},${params}`
}

function betweenDate(dates, operation) {
    return `${operation},${dates[0]},${dates[1]}`
}