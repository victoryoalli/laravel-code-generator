@php
if (!function_exists('inputTextType')) {
    function inputTextType($col_type,$col_name=''){
        switch($col_type){
            case 'Boolean':
                return 'checkbox';
            case 'SmallInt':
                return 'number';
            case 'Integer':
                return 'number';
            case 'Decimal':
                return 'number';
            case 'Date':
                return 'date';
            case 'DateTime':
                return 'datetime-local';
            case 'String':
                if(strpos($col_name,'email')!==false )
                {
                    return 'email';
                }
                elseif(strpos($col_name,'phone')!==false )
                {
                    return 'phone';
                }
                elseif(strpos($col_name,'password')!==false )
                {
                    return 'password';
                }
                elseif(strpos($col_name,'image')!==false )
                {
                    return 'text'; //file
                }
                elseif(strpos($col_name,'video')!==false )
                {
                    return 'text'; //file
                }
                return 'text';
                return 'text';
                return 'text';
            default:
            return 'text';
        }
    }
}
@endphp