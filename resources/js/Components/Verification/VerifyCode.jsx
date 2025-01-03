import React, {useState} from 'react';
import TextInput from "@/Components/TextInput.jsx";
import PrimaryButton from "@/Components/PrimaryButton.jsx";
import {useForm} from "@inertiajs/react";

function VerifyCode({fieldName, fieldValue, nid, onCodeVerified}) {
    const [loading, setLoading] = useState(false)
    const {data, setData, errors, setError, reset} = useForm({
        nid: nid, field_value: fieldValue, field_name: fieldName, code: ''
    })

    const submit = (e) => {
        e.preventDefault();
        setLoading(true)
        axios.post(route('api.v1.enrolls.verify.verify'), data)
            .then(response => response?.data)
            .then((response) => {
                reset()
                onCodeVerified()
            })
            .catch(({response}) => {
                if (response.status === 422) {
                    const errors = response?.data?.errors || {}
                    Object.keys(errors).forEach((key) => {
                        setError('code', errors[key][0])
                    })
                }
            }).finally(() => {
            setLoading(false)
        })
    }

    return (<div className='flex flex-col gap-3'>
        <div className="flex flex-col gap-2">
            <span>Verify {fieldName.toUpperCase()}: {fieldValue}</span>
            <div>
                <TextInput
                    id="code"
                    name="code"
                    value={data.code}
                    className="mt-1 block w-full"
                    autoComplete="name"
                    isFocused={true}
                    onChange={(e) => setData('code', e.target.value)}
                    placeholder='Enter code...'
                />
                {errors.code && <span>{errors.code}</span>}
            </div>
        </div>
        <PrimaryButton onClick={submit} disabled={loading} className='text-center justify-center'>
            Verify Code
        </PrimaryButton>
    </div>);
}

export default VerifyCode;
