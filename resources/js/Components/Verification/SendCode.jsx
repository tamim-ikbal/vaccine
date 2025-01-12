import React, {useEffect, useState} from 'react';
import PrimaryButton from "@/Components/PrimaryButton.jsx";
import {useForm} from "@inertiajs/react";

function SendCode({fieldName, fieldValue, nid, onCodeSent, isResend}) {
    const [loading, setLoading] = useState(false)
    const {data, setData, errors, setError, reset, setDefaults} = useForm({
        nid: nid, field_value: fieldValue, field_name: fieldName
    })

    const sendCode = (e) => {
        e.preventDefault();
        setLoading(true)
        axios.post(route('api.v1.enrolls.verify.send'), data)
            .then(response => response?.data)
            .then((response) => {
                reset()
                onCodeSent()
            })
            .catch(({response}) => {
                if (response.status === 422) {
                    const errors = response?.data?.errors || {}
                    Object.keys(errors).forEach((key) => {
                        setError(key, errors[key][0])
                    })
                }
            }).finally(() => {
            setLoading(false)
        })
    }

    useEffect(() => {
        setData({
            nid: nid,
            field_value: fieldValue,
            field_name: fieldName
        })
    }, [fieldName, fieldValue])

    return (
        <div className='flex flex-col gap-3'>
            <div className="flex flex-col gap-2">
                {errors.field_value && <span>{errors.field_value}</span>}
            </div>
            <PrimaryButton onClick={sendCode} disabled={loading}
                           className='bg-orange-400 text-center justify-center hover:bg-orange-600'>
                {isResend ? 'Resend' : 'Send Code'}
            </PrimaryButton>
        </div>
    );
}

export default SendCode;
