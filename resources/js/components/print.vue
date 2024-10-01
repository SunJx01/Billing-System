<template>
  <div class="print">
    <div class="print-flex">
      <h1>Invoice</h1>
      <div class="preview">
        <pre>{{ invoiceContent }}</pre>
      </div>
      <button @click="printInvoice">Print Invoice</button>
    </div>
  </div>
</template>

<script>
export default {
  props: ['filename'],
  data() {
    return {
      invoiceContent: '',
    };
  },
  mounted() {
    this.fetchInvoice();
  },
  methods: {
    async fetchInvoice() {
      try {
        const response = await fetch(`/storage/${this.filename}`);
        if (!response.ok) throw new Error('File not found');
        this.invoiceContent = await response.text();
      } catch (error) {
        console.error(error);
        this.invoiceContent = 'Error loading invoice.';
      }
    },
    printInvoice() {
      window.print();
    },
  },
};
</script>

<style scoped>
.print {
  padding: 20px;
}

.print-flex {
  display: flex;
  flex-direction: column;
  align-items: center;
}

.preview {
  margin-top: 20px;
  white-space: pre-wrap; 
}
</style>
            // window.open('http://127.0.0.1:8000/storage/' + filename, '_blank');
