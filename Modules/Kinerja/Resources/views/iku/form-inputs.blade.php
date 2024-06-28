@php $editing = isset($iku) @endphp

<div class="row">
    <x-inputs.group class="col-sm-12">
        <x-inputs.number
            name="tahun"
            label="Tahun"
            :value="old('tahun', ($editing ? $iku->tahun : ''))"
            max="2050"
            placeholder="Tahun"
            required
        ></x-inputs.number>
    </x-inputs.group>

    <x-inputs.group class="col-sm-12">
        <x-inputs.text
            name="no"
            label="No"
            :value="old('no', ($editing ? $iku->no : ''))"
            maxlength="20"
            placeholder="No"
            required
        ></x-inputs.text>
    </x-inputs.group>

    <x-inputs.group class="col-sm-12">
        <x-inputs.text
            name="sasaran"
            label="Sasaran"
            :value="old('sasaran', ($editing ? $iku->sasaran : ''))"
            maxlength="200"
            placeholder="Sasaran"
            required
        ></x-inputs.text>
    </x-inputs.group>
</div>
